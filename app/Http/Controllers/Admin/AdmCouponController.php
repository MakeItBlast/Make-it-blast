<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller

use App\Models\Coupon;
use App\Models\IssueType;
use App\Models\SystemValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmCouponController extends Controller
{
    public function getCouponPage(Request $request)
    {
        $uniqueCode = $this->generateCouponCode();
        $getCoupons = Coupon::get();
        $getIssueData = IssueType::all();
        $getSelectedIssueData = IssueType::find($request->id);
        $footerMessage = SystemValue::where('system_key', 'footer_message')->value('system_val');

       
        return view('admin.pages.create-discount', compact('uniqueCode','getCoupons','getIssueData','getSelectedIssueData','footerMessage'));
    }

    public function updateCpnForm(Request $request){

        $updId = $request->input('updId');

        $getCoupons = Coupon::get();

        $getCouponStr = Coupon::find($updId);
        $getIssueData = IssueType::all();
        $footerMessage = SystemValue::where('system_key', 'footer_message')->first();

        return view('admin.pages.create-discount', compact('getCouponStr','getCoupons','getIssueData','footerMessage'));

    }

    public function deleteCpn(Request $request){

        $delId = $request->input('delId');
        $delete = Coupon::where('id', $delId)->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully!');

    }

    public function changeStatusCpn(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:10|exists:coupons,id',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $statusId = $request->input('id');

            // Find the coupon by ID
            $coupon = Coupon::find($statusId);

            if (!$coupon) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'id not found',
                ]);
            }

            // Toggle the status
            $coupon->status = ($coupon->status === 'active') ? 'inactive' : 'active';
            $coupon->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Changed Successfully',
            ]);
            
            
            
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
    }

    }

    

    public function createOrUpdateCoupon(Request $request)
     {

        try{
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'cpn_code'     => 'required|string|min:6|max:10|unique:coupons,cpn_code',
                'cpn_credit'   => 'required|numeric|min:0',
                'cpn_exp_date' => 'required|date|after:today',
                'cpn_status'   => 'in:active,inactive',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $status = $request->has('cpn_status') ? 'active' : 'inactive';


            // Prepare data for insert/update
            $data = [
                'cpn_code'     => $request->input('cpn_code'),
                'credit_cost'  => $request->input('cpn_credit'),
                'cpn_exp_date' => $request->input('cpn_exp_date'),
                'status'       => $status,
            ];

            // Check if it's an update or create
            if ($request->has('updId') && !empty($request->input('updId'))) {
                // Update
                $coupon = Coupon::find($request->input('updId'));
                if (!$coupon) {
                    return redirect()->back()->with('error', 'Coupon not found.');
                }
                $coupon->update($data);
                $message = 'Coupon updated successfully!';
            } else {
                // Create
                $coupon = Coupon::create($data);
                $message = 'Coupon created successfully!';
            }

            return redirect('create-discount')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
        }
    }

    public function generateCouponCode()
    {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codeLength = 7;
    $code = '';

    do {
        $code = '';
        for ($i = 0; $i < $codeLength; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        
    } while (Coupon::where('cpn_code', $code)->exists());

    return $code;
    }

    //add footer message

    public function addFooterMessage(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'footer_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $storeFooterMsg = SystemValue::updateOrCreate(
            ['system_key' => 'footer_message'], // Search condition
            ['system_val' => $request->footer_message] // Values to insert or update
        );

        if ($storeFooterMsg) {
            return redirect()->back()->with('success', 'Footer message saved successfully.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to save footer message.'])->withInput();
        }

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
    }
}

    


}