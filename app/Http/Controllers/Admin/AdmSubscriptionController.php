<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller
use App\Models\Subscription;
use App\Models\SubscriptionConnUser;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdmSubscriptionController extends Controller
{
    //
    public function createSubscription(Request $request){

        $getAllSubscriptions = Subscription::all();

        return view('admin.pages.create-sub',compact('getAllSubscriptions'));
    }

    public function storeOrUpdateSubscription(Request $request)
    {
    try {
        
        
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'subsc_name' => 'required|string|max:255|unique:subscriptions,subsc_name',
            'keyword_allowed_count' => 'required|integer',
            'sms_allowed_count' => 'required|integer',
            'email_allowed_count' => 'required|integer',
            'social_allowed_count' => 'required|integer',
            'ai_allowed_count' => 'required|integer',
            'image_allowed_count' => 'required|integer',
            'replies_allowed_count' => 'required|integer',
            'duration' => 'required|integer|min:1',
            'credit_cost' => 'required|numeric|min:0',
            'monthly_cost' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'yearly_cost' => 'required|numeric|min:0',
            'surcharge' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
        ]);
        
       
        if ($validator->fails()) {
             
            return redirect()->back()->withErrors($validator)->withInput();
        
        }
    
        $status = $request->has('status') ? $request->status : 'inactive';
       
        // Prepare data array
        $subscriptionData = [
            'subsc_name' => $request->input('subsc_name'),
            'keyword_allowed_count' => $request->input('keyword_allowed_count'),
            'sms_allowed_count' => $request->input('sms_allowed_count'),
            'email_allowed_count' => $request->input('email_allowed_count'),
            'social_allowed_count' => $request->input('social_allowed_count'),
            'ai_allowed_count' => $request->input('ai_allowed_count'),
            'image_allowed_count' => $request->input('image_allowed_count'),
            'replies_allowed_count' => $request->input('replies_allowed_count'),
            'duration' => $request->input('duration'),
            'credit_cost' => $request->input('credit_cost'),
            'monthly_cost' => $request->input('monthly_cost'),
            'discount' => $request->input('discount'),
            'yearly_cost' => $request->input('yearly_cost'),
            'surcharge' => $request->input('surcharge'),
            'status' => $status,
        ];
       

        // Check if updating or creating a new subscription
        if ($request->filled('updId')) {
          
            $subscription = Subscription::find($request->updId);
            if (!$subscription) {
                //return redirect()->back()->withErrors(['error' => 'Subscription not found'])->withInput();
                return redirect('create-subscription')->with('error', 'Subscription not updated')->withInput();
            }

            $subscription->update($subscriptionData);
            //return redirect()->back()->with('success', 'Subscription updated successfully');
            return redirect('create-subscription')->with('success', 'Subscription updated successfully');
        } else {
            Subscription::create($subscriptionData);
          
            return redirect()->back()->with('success', 'Subscription added successfully');
        }
    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'Some critical error occurred: ' . $e->getMessage()])
            ->withInput();
    }
}


//delete subscription
public function deleteSubscription(Request $request)
{
    try {

       
       
        $delId = $request->delId;
        // Validate the ID to ensure it's a positive integer
        if (!is_numeric($delId) || $delId <= 0) {
            return redirect('create-subscription')->withErrors(['error' => 'Invalid Subscription ID']);
        }

        // Attempt to find the subscription
        $subscription = Subscription::where('id', $delId)->first();

        if (!$subscription) {
            return redirect('create-subscription')->withErrors(['error' => 'Subscription not found']);
        }

        // Check if subscription is already purchased
        $isPurchased = SubscriptionConnUser::where('subscription_id', $delId)->exists();

        //print_r($isPurchased);
        //die();

        if ($isPurchased) {
            return redirect('create-subscription')->withErrors(['error' => 'Cannot delete. This subscription has already been purchased by one or more users.']);
        }

        // Delete the subscription
        $subscription->delete();

        return redirect('create-subscription')->with('success', 'Subscription deleted successfully');

    } catch (\Exception $e) {
        return redirect('create-subscription')->withErrors(['error' => 'Some critical error occurred: ' . $e->getMessage()]);
    }
}


    //populate form filed to update the content
    public function updateSubscription(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'updId' => 'required|string|max:255',  
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateSubscription = Subscription::find($request->updId);
        $getAllSubscriptions = Subscription::all();
    
         return view('admin.pages.create-sub',compact('getAllSubscriptions','updateSubscription'));
        //return redirect('/create-subscription')->with(compact('getAllSubscriptions', 'updateSubscription'));

    }
    
    public function showServicePayPage(Request $request){

        $allPaymentData = Payment::with(['coupon', 'user','invoice'])->get();
        return view('admin.pages.service-payments',compact('allPaymentData'));

    }
    
}
