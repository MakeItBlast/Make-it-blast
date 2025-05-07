<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SubscriptionConnUser;
use App\Models\Coupon;
use App\Models\CardDetails;
use App\Models\ExtraCredit;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Stripe\Exception\RateLimitException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function getPaymentDetail(){
        // Assuming you are using an ORM (like Eloquent in Laravel or similar)


        $user = auth()->user();

        $cardDetails = CardDetails::where('user_id', $user->id)->get();
        
         
         return view('admin.pages.payment', compact('cardDetails'));
    }

    public function storeOrUpdateCardDetail(Request $request)
    {
        try {
            // Validation for the input data
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'card_number' => 'required|numeric|digits_between:13,16',
                'cvv' => 'required|numeric|digits:3',
                'exp_date' => [
                    'required',
                    'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                    function ($attribute, $value, $fail) {
                        [$month, $year] = explode('/', $value);
                        $fullYear = '20' . $year;
                        $expiryDate = Carbon::createFromFormat('Y-m-d', "{$fullYear}-{$month}-01")->endOfMonth();
                        if ($expiryDate->lt(now())) {
                            $fail('The expiration date must be a future date.');
                        }
                    }
                ],
                'country' => 'nullable|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'priority' => 'nullable|integer|between:1,5',
                'status' => 'nullable|string|max:255',
                'id' => 'nullable|exists:card_details,id' // Ensures valid ID if provided
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $curr_userId = auth()->id();
            $cardData = [
                'f_name' => $request->input('f_name'),
                'l_name' => $request->input('l_name'),
                'card_number' => $request->input('card_number'),
                'cvv' => $request->input('cvv'),
                'exp_date' => $request->input('exp_date'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'priority' => $request->input('priority'),
                'status' => $request->input('status'),
                'user_id' => $curr_userId,
            ];
    
            if ($request->has('id')) {
                // Update existing record
                $cardDetail = CardDetails::findOrFail($request->input('id'));
                $cardDetail->update($cardData);
                return redirect()->back()->with('success', "Card updated successfully");
            } else {
                // Create new record
                $addnewCardDetail = CardDetails::create($cardData);
                if ($addnewCardDetail) {
                    return redirect()->back()->with('success', "Card added successfully");
                } else {
                    return redirect()->back()->withErrors('Card not able to add')->withInput();
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Some critical Error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function storePayment(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'stripeToken' => 'required|string',
                'total_amount' => 'required|numeric|min:0.5',
                'payment_type' => 'required|string|in:m,y',
                'items' => 'required|json',
                'subscription_id' => 'nullable|string',
                'credits' => 'nullable|integer',
                'country' => 'nullable|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            

            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $user = auth()->user();
            $amount = $request->total_amount * 100; // Convert to cents

            // Create a customer in Stripe
            $customer = Customer::create([
                'email' => $user->email,
                'source' => $request->stripeToken,
                'name' => $request->f_name . ' ' . $request->l_name,
                'address' => [
                    'city' => $request->city,
                    'country' => $request->country,
                    'line1' => '',
                    'line2' => '',
                    'postal_code' => '',
                    'state' => $request->state,
                ]
            ]);

            

            // Create a charge
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $customer->id,
                'description' => 'Payment for subscription/credits',
                'metadata' => [
                    'user_id' => $user->id,
                    'payment_type' => $request->payment_type,
                    'items' => $request->items
                ]
            ]);

            // Save payment details in database
            $payment = Payment::create([
                'user_id' => $user->id,
                'stripe_charge_id' => $charge->id,
                'amount' => $request->total_amount,
                'currency' => 'usd',
                'payment_status' => $charge->status,
                'payment_method' => 'stripe',
                'payment_type' => $request->payment_type,
                'items' => $request->items,
                'billing_details' => json_encode([
                    'name' => $request->f_name . ' ' . $request->l_name,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city
                ])
            ]);

            // Handle subscription if exists
            if ($request->subscription_id) {
                $subscriptionIds = explode(',', $request->subscription_id);
                foreach ($subscriptionIds as $subId) {
                    [$subscriptionId, $paymentType] = explode('-', $subId);
                    
                    SubscriptionConnUser::create([
                        'user_id' => $user->id,
                        'subscription_id' => $subscriptionId,
                        'payment_id' => $payment->id,
                        'amt_type' => $paymentType == 'm' ? 'monthly' : 'yearly',
                        'status' => 'active'
                    ]);
                }
            }

            // Handle credits if exists
            if ($request->credits) {
                ExtraCredit::create([
                    'user_id' => $user->id,
                    'trx_id' => $charge->id,
                    'credit' => $request->credits
                ]);
            }

            return redirect()->route('payment.success')
                ->with('success', 'Payment successful!');

        } catch (CardException $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getError()->message])
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Payment failed: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function paymentSuccess()
    {
        return view('admin.payment.success');
    }

    public function updateCardDetails(Request $request, $updId)
    {

        
        $user = auth()->user();

        $cardDetailsUpd = CardDetails::where('user_id', $user->id)
                                 ->where('id', $updId)
                                 ->first();
        
       
        $cardDetails = CardDetails::where('user_id', $user->id)->get();
       
         return view('admin.pages.payment', compact('cardDetailsUpd', 'cardDetails' ));
    }

    public function deleteCardDetails($delId)
    {
    
    
        $deleteStatus = CardDetails::where('id', $delId)
            ->delete();
    
        if ($deleteStatus) {
            return redirect()->back()->with('success', "Card deleted successfully");
        } else {
            return redirect()->back()->withErrors(['error' => 'No matching record found or deletion failed']);
        }

        return view('admin.pages.payment');
    }
    
}