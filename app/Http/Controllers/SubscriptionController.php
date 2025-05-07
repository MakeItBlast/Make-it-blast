<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{


    //get subscription
    public function getSubscriptionData()
        {
    
    $subscriptions = Subscription::all(); 
//print_r($subscriptions);
    
    return view('admin.pages.subscription', compact('subscriptions'));
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

       
    

    
}
