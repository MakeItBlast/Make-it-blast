<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SubscriptionConnUser;
use App\Models\CardDetails;

class SubscriptionController extends Controller
{


    //get subscription
    public function getSubscriptionData()
        {
    $subscriptions = Subscription::all(); 
    $user = auth()->id();
    $cardDetails = CardDetails::where('user_id', $user)->get();
    $subscriptions = Subscription::where('status','active')->get();
    
    // Get user's active subscriptions with their related subscription data
    $userSubscriptions = SubscriptionConnUser::with(['subscription', 'payment'])
        ->where('user_id', $user)
        ->where('status', 'active')
        ->get();

    // return view('admin.pages.payment', [
    //     'cardDetails' => $cardDetails,
    //     'subscriptions' => $subscriptions,
    //     'userSubscriptions' => $userSubscriptions
    // ]);
    
    //$success_subscription = 

    
    return view('admin.pages.subscription', compact('subscriptions','cardDetails','userSubscriptions'));
        }

    //update subscrition
    public function updateSubscriptionData(){

    }

   
        public function subscriptionAddToList(Request $request)
        {
            // Validate subscription_id
            $request->validate([
                'subscription_id' => 'required|exists:subscriptions,id', // Ensure the subscription exists
            ]);
    
            // Get the subscription from the database
            $subscriptionId = $request->input('subscription_id');
            $subscription = Subscription::find($subscriptionId);
    
            if (!$subscription) {
                return response()->json(['success' => false, 'message' => 'Subscription not found!']);
            }
    
            // Option 1: Use Session (Add to session list)
            $userList = session()->get('user_list', []);

            // print_r($subscription);die;
    
            // Avoid adding duplicate subscriptions
            if (!in_array($subscriptionId, array_column($userList, 'id'))) {
                $userList[] = $subscription;
                session()->put('user_list', $userList);
            }
    
            // Option 2: Using Database (Optional, if you need persistent data)
            // UserList::create([
            //     'user_id' => auth()->id(),
            //     'subscription_id' => $subscriptionId,
            // ]);
    
            // Return response with the new item
            return response()->json([
                'success' => true,
                'newItem' => $subscription,  // Send the new item data back to display
                'message' => 'Item added to list successfully!'
            ]);
        }

       
    //change the status of subscription
public function updateSubscriptionStatus(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
 
        $upd = Subscription::find($request->id); // <-- Corrected line
 
        if (!$upd) {
            return response()->json([
                'status' => 200,
                'message' => 'id not found',
            ]);
        }
 
        $newStatus = $upd->status === 'active' ? 'inactive' : 'active';
 
        $chk = $upd->update(['status' => $newStatus]);
 
        if ($chk) {
            return response()->json([
                'status' => 'success',
                'message' => 'Status updated to ' . $newStatus,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status.',
            ]);
        }
 
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Exception: ' . $e->getMessage()
        ]);
    }
}

    
}
