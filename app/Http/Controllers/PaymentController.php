<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Payment, SubscriptionConnUser, Subscription, CardDetails, ExtraCredit, SubscriptionPaymentLog, Invoice, User, UserMetaData};
use Illuminate\Support\Facades\{DB, Validator, Log};
use Carbon\Carbon;
use Stripe\{Stripe, PaymentIntent, PaymentMethod};
use Stripe\Exception\{CardException, ApiErrorException};
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    //     public function getPaymentDetail()
    // {
    //     $userId = auth()->id();

    //     return view('admin.pages.payment', [
    //         'cardDetails' => CardDetails::where('user_id', $userId)->orderBy('priority', 'desc')->get(),
    //         'subscriptions' => Subscription::all(),
    //         'userSubscriptions' => SubscriptionConnUser::with(['subscription', 'payment']),
    //         'invoice' => Invoice::where('user_id', $userId)
    //             ->where('status', 'active')
    //             ->get()
    //     ]);
    // }

    public function getPaymentDetail()
    {
        $userId = auth()->id();

        $cardDetails = CardDetails::where('user_id', $userId)
            ->orderBy('priority', 'desc')
            ->get();

        $subscriptions = Subscription::all();

        $userSubscriptions = SubscriptionConnUser::with(['subscription', 'payment'])->get();

        $invoice = Invoice::where('user_id', $userId)->get();
        $user_invoice = User::find($userId);
        $user_invoice_meta = UserMetaData::where('user_id', $userId)->get();

        return view('admin.pages.payment', compact(
            'cardDetails',
            'subscriptions',
            'userSubscriptions',
            'invoice',
            'user_invoice',
            'user_invoice_meta'
        ));
    }



    public function cancelSubscription(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'subscription_id' => 'required|exists:subscription_conn_users,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Invalid subscription ID'], 422);
            }

            $subscription = SubscriptionConnUser::where('id', $request->subscription_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$subscription) {
                return response()->json(['success' => false, 'message' => 'Subscription not found'], 404);
            }

            $subscription->update(['status' => 'cancelled']);
            return response()->json(['success' => true, 'message' => 'Subscription cancelled successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error cancelling subscription: ' . $e->getMessage()], 500);
        }
    }


public function storeOrUpdateCardDetail(Request $request)
{
    try {
        $cardId = $request->input('id'); // Used for update
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'card_number' => [
                'required',
                'numeric',
                'digits_between:13,16',
                Rule::unique('card_details', 'card_number')
                    ->where(function ($query) use ($userId) {
                        return $query->where('user_id', $userId);
                    })
                    ->ignore($cardId) // Exclude current record if updating
            ],
            'cvv' => 'required|numeric|digits:3',
            'exp_date' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                function ($attribute, $value, $fail) {
                    [$month, $year] = explode('/', $value);
                    try {
                        $expiryDate = Carbon::createFromFormat('Y-m-d', "20{$year}-{$month}-01")->endOfMonth();
                        if ($expiryDate->lt(now())) {
                            $fail('The expiration date must be a future date.');
                        }
                    } catch (\Exception $e) {
                        $fail('Invalid expiration date format.');
                    }
                }
            ],
            'country' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'priority' => 'nullable|integer|between:1,5',
            'status' => 'nullable|string|max:255',
            'id' => 'nullable|exists:card_details,id'
        ], [
            'card_number.unique' => 'This card is already added to your account.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cardData = $request->only([
            'f_name', 'l_name', 'card_number', 'cvv', 'exp_date',
            'country', 'state', 'city', 'priority', 'status'
        ]);
        $cardData['user_id'] = $userId;

        if ($cardId) {
            $card = CardDetails::where('id', $cardId)->where('user_id', $userId)->first();
            if (!$card) {
                return redirect()->back()->withErrors(['error' => 'Card not found or access denied'])->withInput();
            }
            $card->update($cardData);
            return redirect()->back()->with('success', 'Card updated successfully');
        }

        CardDetails::create($cardData);
        return redirect()->back()->with('success', 'Card added successfully');
        
    } catch (\Exception $e) {
        return redirect()->back()->withErrors([
            'error' => 'An error occurred: ' . $e->getMessage()
        ])->withInput();
    }
}


    public function processPaymentAndSubscription(Request $request)
    {
        DB::beginTransaction();
        try {
            // Log the incoming request for debugging
            Log::info('Payment Request Received:', $request->all());

            // Validate the main request structure
            $validator = Validator::make($request->all(), [
                'subscription_items' => 'required|array',
                'payment_data' => 'required|array',
            ]);

            if ($validator->fails()) {
                Log::error('Main validation failed', ['errors' => $validator->errors()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request structure',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Now validate the nested data
            $subscriptionItems = $request->input('subscription_items', []);
            $paymentData = $request->input('payment_data', []);

            $validator = Validator::make([
                'subscription_items' => $subscriptionItems,
                'payment_data' => $paymentData
            ], [
                'subscription_items' => 'required|array',
                'subscription_items.*.name' => 'required|string',
                'subscription_items.*.pay_type' => 'required|string|in:m,y,one-time',
                'subscription_items.*.credits' => 'required|integer|min:0',
                'subscription_items.*.subsc_id' => 'nullable|exists:subscriptions,id',
                'payment_data.f_name' => 'required|string|max:255',
                'payment_data.l_name' => 'required|string|max:255',
                'payment_data.total_amount' => 'required|numeric|min:0',
                'payment_data.payment_type' => 'required|string|in:m,y',
                'payment_data.items' => 'required|json',
                'payment_data.subscription_id' => 'nullable|string',
                'payment_data.credits' => 'nullable|integer|min:0',
                'payment_data.country' => 'required|string|max:255',
                'payment_data.country_code' => 'required|string|size:2',
                'payment_data.state' => 'required|string|max:255',
                'payment_data.city' => 'required|string|max:255',
                'payment_data.payment_method' => 'required|string|in:existing,new',
                'payment_data.save_card' => 'nullable|boolean',
                'payment_data.card_id' => 'nullable|exists:card_details,id,user_id,' . auth()->id(),
                'payment_data.stripeToken' => 'nullable|string|required_if:payment_data.payment_method,new'
            ]);

            if ($validator->fails()) {
                Log::error('Detailed validation failed', ['errors' => $validator->errors()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();

            // Validate subscription items
            foreach ($subscriptionItems as $item) {
                if ($item['name'] !== 'Added Credits' && !empty($item['subsc_id'])) {
                    $subscription = Subscription::find($item['subsc_id']);

                    if (!$subscription) {
                        throw new \Exception("Invalid subscription ID: {$item['subsc_id']}");
                    }

                    // Check for duplicate free subscriptions
                    if ($subscription->monthly_cost == 0 && $subscription->yearly_cost == 0) {
                        $hasSubscribed = SubscriptionConnUser::where('user_id', $user->id)
                            ->where('subscription_id', $item['subsc_id'])
                            ->exists();
                        if ($hasSubscribed) {
                            throw new \Exception("You have already subscribed to the {$item['name']} free plan. This plan can only be subscribed to once per account.");
                        }
                    }
                }
            }

            // Create payment log
            $paymentLog = SubscriptionPaymentLog::create([
                'user_id' => $user->id,
                'amount' => $paymentData['total_amount'],
                'currency' => 'usd',
                'status' => 'initiated',
                'payment_method' => $paymentData['payment_method'] === 'existing' ? 'saved_card' : 'stripe',
                'subscription_items' => json_encode($subscriptionItems),
                'stripe_response' => null
            ]);

            // Verify total amount matches calculated amount
            $calculatedAmount = 0;
            foreach ($subscriptionItems as $item) {
                if ($item['name'] === 'Added Credits') {
                    $calculatedAmount += $item['credits'] * 0.05;
                } else {
                    $subscription = Subscription::find($item['subsc_id']);
                    $cost = $item['pay_type'] === 'm' ? $subscription->monthly_cost : $subscription->yearly_cost;
                    $discount = $item['pay_type'] === 'y' ? ($subscription->discount ?? 0) : 0;
                    $calculatedAmount += $cost - $discount;
                }
            }

            if (abs($calculatedAmount - $paymentData['total_amount']) > 0.01) {
                throw new \Exception('Total amount mismatch. Expected: $' . number_format($calculatedAmount, 2) .
                    ', Received: $' . number_format($paymentData['total_amount'], 2));
            }

            // Process payment if amount > 0
            $paymentIntent = null;
            $paymentMethod = null;

            if ($paymentData['total_amount'] > 0) {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                if ($paymentData['payment_method'] === 'existing') {
                    // Process with saved card
                    $card = CardDetails::where('id', $paymentData['card_id'])
                        ->where('user_id', $user->id)
                        ->first();

                    if (!$card) {
                        throw new \Exception('Selected card not found');
                    }

                    // Create payment method from saved card
                    try {
                        $paymentMethod = PaymentMethod::create([
                            'type' => 'card',
                            'card' => [
                                'number' => $card->card_number,
                                'exp_month' => explode('/', $card->exp_date)[0],
                                'exp_year' => '20' . explode('/', $card->exp_date)[1],
                                'cvc' => $card->cvv
                            ],
                            'billing_details' => [
                                'name' => $card->f_name . ' ' . $card->l_name,
                                'address' => [
                                    'country' => $paymentData['country_code'],
                                    'state' => $paymentData['state'],
                                    'city' => $paymentData['city']
                                ]
                            ]
                        ]);

                        $paymentIntent = PaymentIntent::create([
                            'amount' => (int)($paymentData['total_amount'] * 100),
                            'currency' => 'usd',
                            'payment_method' => $paymentMethod->id,
                            'confirm' => true,
                            'description' => 'Payment using saved card',
                            'metadata' => [
                                'user_id' => $user->id,
                                'card_last4' => substr($card->card_number, -4),
                                'log_id' => $paymentLog->id
                            ],
                            'return_url' => route('payment.success')
                        ]);
                    } catch (CardException $e) {
                        throw new \Exception('Card error: ' . $e->getError()->message);
                    }
                } else {
                    // Process with new card
                    try {
                        $paymentIntent = PaymentIntent::create([
                            'amount' => (int)($paymentData['total_amount'] * 100),
                            'currency' => 'usd',
                            'payment_method' => $paymentData['stripeToken'],
                            'confirm' => true,
                            'description' => 'Payment for subscription/credits',
                            'metadata' => [
                                'user_id' => $user->id,
                                'payment_type' => $paymentData['payment_type'],
                                'items' => $paymentData['items'],
                                'log_id' => $paymentLog->id
                            ],
                            'return_url' => route('payment.success')
                        ]);

                        // Save card if requested
                        if ($paymentData['save_card'] ?? false) {
                            $paymentMethod = PaymentMethod::retrieve($paymentData['stripeToken']);
                            CardDetails::create([
                                'user_id' => $user->id,
                                'f_name' => $paymentData['f_name'],
                                'l_name' => $paymentData['l_name'],
                                'card_number' => '**** **** **** ' . $paymentMethod->card->last4,
                                'exp_date' => $paymentMethod->card->exp_month . '/' . substr($paymentMethod->card->exp_year, -2),
                                'cvv' => '***',
                                'country' => $paymentData['country'],
                                'state' => $paymentData['state'],
                                'city' => $paymentData['city'],
                                'priority' => 0
                            ]);
                        }
                    } catch (CardException $e) {
                        throw new \Exception('Card error: ' . $e->getError()->message);
                    }
                }

                // Check payment status
                if ($paymentIntent->status !== 'succeeded') {
                    $paymentLog->update([
                        'status' => 'requires_action',
                        'stripe_response' => json_encode($paymentIntent)
                    ]);

                    if ($paymentIntent->status === 'requires_action') {
                        return response()->json([
                            'success' => false,
                            'requires_action' => true,
                            'payment_intent_client_secret' => $paymentIntent->client_secret
                        ]);
                    }

                    throw new \Exception('Payment failed: ' . ($paymentIntent->last_payment_error->message ?? 'Unknown error'));
                }

                $paymentLog->update([
                    'transaction_id' => $paymentIntent->id,
                    'status' => $paymentIntent->status,
                    'stripe_response' => json_encode($paymentIntent)
                ]);
            } else {
                // Zero amount payment (free subscription)
                $paymentLog->update([
                    'transaction_id' => 'zero_cost_' . uniqid(),
                    'status' => 'succeeded',
                    'stripe_response' => json_encode(['message' => 'Zero cost transaction'])
                ]);
            }

            // Create Payment Record
            $payment = Payment::create([
                'user_id' => $user->id,
                'transaction_id' => $paymentLog->transaction_id,
                'amount' => $paymentData['total_amount'],
                'currency' => 'usd',
                'status' => $paymentLog->status,
                'payment_method' => $paymentData['total_amount'] > 0 ?
                    ($paymentData['payment_method'] === 'existing' ? 'saved_card' : 'stripe') : 'none',
                'response_data' => $paymentLog->stripe_response,
            ]);

            // Process subscriptions and credits
            foreach ($subscriptionItems as $item) {
                if ($item['name'] === 'Added Credits') {
                    ExtraCredit::create([
                        'user_id' => $user->id,
                        'trx_id' => $payment->id,
                        'credit' => $item['credits']
                    ]);
                } else {
                    $subscription = Subscription::find($item['subsc_id']);

                    // Check for existing active subscription of same type
                    if ($subscription->monthly_cost > 0 || $subscription->yearly_cost > 0) {
                        $existingSubscription = SubscriptionConnUser::where('user_id', $user->id)
                            ->where('subscription_id', $item['subsc_id'])
                            ->where('amt_type', $item['pay_type'] === 'm' ? 'monthly' : 'yearly')
                            ->where('status', 'active')
                            ->exists();

                        if ($existingSubscription) {
                            throw new \Exception("You already have an active {$item['name']} subscription with the same payment type.");
                        }
                    }

                    SubscriptionConnUser::create([
                        'user_id' => $user->id,
                        'subscription_id' => $item['subsc_id'],
                        'payment_id' => $payment->id,
                        'amt_type' => $item['pay_type'] === 'm' ? 'monthly' : 'yearly',
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            $stripeToken = $paymentData['stripeToken'];
            $description = json_encode($subscriptionItems);
            $total = $paymentData['total_amount'];


            $this->generateInvoice_andMail($stripeToken, $description, $total);


            return response()->json([
                'success' => true,
                'message' => 'Payment and subscription processed successfully',
                'log_id' => $paymentLog->id,
                'redirect_url' => route('payment.success')
            ]);
        } catch (CardException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Card error: ' . $e->getError()->message
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateInvoice_andMail($stripeToken, $description, $total)
    {
        try {
            do {
                $invoiceNumber = random_int(1000000, 9999999);
            } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            $invoiceData = [
                'user_id'    => auth()->id(),
                'invoice_number' => $invoiceNumber,
                'description'    => $description,
                'total'          => $total,
                'trx_id'         => $stripeToken, // Now it's directly a string, no array access
            ];

            $invoice = Invoice::create($invoiceData);

            // Get authenticated user's email
            $userEmail = auth()->user()->email;

            // Send invoice via email
            $this->sendInvoiceEmail($userEmail, $invoiceData);
        } catch (\Exception $e) {
            \Log::error("Invoice generation failed: " . $e->getMessage());
            return response()->json(['error' => 'Invoice generation failed.'], 500);
        }
    }

    public function sendInvoiceEmail($userEmail, $invoiceData)
    {
        try {
            // Extract 'name' from description JSON
            $descriptionArray = json_decode($invoiceData['description'], true);
            $name = is_array($descriptionArray) && isset($descriptionArray[0]['name'])
                ? $descriptionArray[0]['name']
                : 'N/A';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nextupgradwebsolutions@gmail.com';
            $mail->Password = 'rdbq zljz cyrf dtsc';
            $mail->Port = 587;

            $mail->setFrom('developer11.nextupgrad@gmail.com', 'NextUpgrad Web Solutions');
            $mail->addAddress($userEmail);
            $mail->addBCC('akansha.nextupgrad@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Your Invoice from NextUpgrad Web Solutions';

            $mail->Body = '
                <div style="font-family: Arial, sans-serif; margin: 0 auto; color: #333;">
                    <!-- Header Section -->
                    <div style="background-color: #f8f9fa; padding: 20px; text-align: center; border-bottom: 3px solid #4CAF50;">
                        <h1 style="color: #2c3e50; margin: 0;">INVOICE</h1>
                        <p style="margin: 5px 0 0; color: #7f8c8d;">#' . $invoiceData['invoice_number'] . '</p>
                    </div>
                    
                    <div style="padding: 20px;">
                        <!-- Logo and Date Table -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" valign="top" align="left">
                                    <h3 style="font-size:25px; color:#000;"> Make It Blast </h3>
                                </td>
                                <td width="50%" valign="top" align="right">
                                    <p style="margin: 5px 0;"><strong>Date:</strong> ' . date('M j, Y') . '</p>
                                    <p style="margin: 5px 0;"><strong>Status:</strong> <span style="color: #4CAF50;">Completed</span></p>
                                </td>
                            </tr>
                        </table>
                        
                        <!-- Transaction Details -->
                        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                            <h3 style="margin-top: 0; color: #2c3e50;">Transaction Details</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Transaction ID:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">' . $invoiceData['trx_id'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Description:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">' . $name . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;"><strong>Total Amount:</strong></td>
                                    <td style="padding: 8px 0; text-align: right; font-weight: bold; color: #2c3e50;">$' . number_format($invoiceData['total'], 2) . '</td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Footer -->
                        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; text-align: center;">
                            <h3 style="margin-top: 0; color: #2c3e50;">Thank You!</h3>
                            <p style="margin-bottom: 0;">We appreciate your business. If you have any questions, feel free to contact us:</p>
                            <p style="margin: 10px 0;">
                                <strong>Phone:</strong> +1 (408) 400-3232 / +1 (408) 786-5558<br>
                                <strong>Website:</strong> <a href="https://53c50cd527.nxcli.io/make-it-blast/dashboard" style="color: #4CAF50; text-decoration: none;">blastitnow.com</a>
                            </p>
                        </div>
                    </div>
                    
                    <div style="background-color: #2c3e50; color: white; text-align: center; padding: 15px; font-size: 12px;">
                        <p style="margin: 0;">© ' . date('Y') . ' Make It Blast. All rights reserved.</p>
                    </div>
                </div>';

            $mail->send();
            return true;
        } catch (\Exception $e) {
            \Log::error('Invoice Email Send Error: ' . $e->getMessage());
            return false;
        }
    }




    public function paymentSuccess()
    {
        return redirect('subscription')->with('success', 'Payment processed successfully');
    }

    public function updateCardDetails(Request $request, $updId)
    {
        $user = auth()->user();
        $invoice = Invoice::where('user_id', $user->id)->get();
        $cardDetailsUpd = CardDetails::where('user_id', $user->id)->where('id', $updId)->first();
        $cardDetails = CardDetails::where('user_id', $user->id)->get();
        $user_invoice = User::find($user->id);
        $user_invoice_meta = UserMetaData::where('user_id', $user->id)->get();
        return view('admin.pages.payment', compact('cardDetailsUpd', 'cardDetails','invoice','user_invoice','user_invoice_meta'));
    }

    public function deleteCardDetails($delId)
    {
        try {
            $deleteStatus = CardDetails::where('id', $delId)->delete();
            if ($deleteStatus) {
                return redirect()->back()->with('success', 'Card deleted successfully');
            }
            return redirect()->back()->withErrors(['error' => 'No matching record found or deletion failed']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Processing failed: ' . $e->getMessage()], 500);
        }
    }

    public function togglePriority(Request $request)
    {
        $cardId = $request->input('cardId');
        $card = CardDetails::find($cardId);

        if (!$card || $card->user_id !== auth()->id()) {
            return response()->json(['error' => 'Card not found or unauthorized'], 404);
        }

        CardDetails::where('user_id', auth()->id())->where('id', '!=', $cardId)->update(['priority' => 0]);
        $card->update(['priority' => 1]);

        return response()->json(['response' => 'Priority updated successfully']);
    }
}
