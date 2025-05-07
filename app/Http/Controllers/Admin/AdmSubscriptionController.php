<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller
use App\Models\Subscription;
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
            'subsc_name' => 'required|string|max:255',
            'keyword_allowed_count' => 'required|integer|min:1',
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
            'duration' => $request->input('duration'),
            'credit_cost' => $request->input('credit_cost'),
            'monthly_cost' => $request->input('monthly_cost'),
            'discount' => $request->input('discount'),
            'yearly_cost' => $request->input('yearly_cost'),
            'surcharge' => $request->input('surcharge'),
            'status' => $status,
        ];

        // Check if updating or creating a new subscription
        if ($request->filled('id')) {
            $subscription = Subscription::find($request->id);
            if (!$subscription) {
                return redirect()->back()->withErrors(['error' => 'Subscription not found'])->withInput();
            }

            $subscription->update($subscriptionData);
            return redirect()->back()->with('success', 'Subscription updated successfully');
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


    public function deleteSubscription($delId)
    {
     
        try {
            // Validate the ID to ensure it's a positive integer
            if (!is_numeric($delId) || $delId <= 0) {
                return redirect()->back()->withErrors(['error' => 'Invalid Subscription ID']);
            }
    
          
            // Attempt to find and delete the subscription
            $subscription = Subscription::where('id', $delId)->first();
    
            if (!$subscription) {
                return redirect()->back()->withErrors(['error' => 'Subscription not found']);
            }
    
            // Delete the subscription
            $subscription->delete();
    
            return redirect()->back()->with('success', 'Subscription deleted successfully');
    
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Some critical error occurred: ' . $e->getMessage()]);
        }
    }


    public function updateSubscription($updId)
    {
        $updateSubscription = Subscription::find($updId);
        $getAllSubscriptions = Subscription::all();
    
        return view('admin.pages.create-sub', compact('getAllSubscriptions', 'updateSubscription'));
    }
    
    
    
}