<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller
// use App\Models\Subscription;
// use App\Models\SubscriptionConnUser;
// use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminReportController extends Controller
{
    public function viewReportPage(Request $request){
        return view('admin.pages.blast-report');
    }

    public function filterData(Request $request){
        $validator = Validator::make($request->all(), [
            'subscription'      => 'required',
            'more_credit'       => 'nullable|integer|min:0',
            'less_credit'       => 'nullable|integer|min:0',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'company_name'      => 'required|string|max:255',
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'state'             => 'required|string|max:100',
            'options'           => 'nullable|string',
            'blast_start_time'  => 'nullable|date_format:H:i',
            'blast_end_time'    => 'nullable|date_format:H:i|after:blast_start_time',
            'time_zone'         => 'required|string',
            'integration'       => 'nullable|string',
            'picture'           => 'nullable|string|max:2048',
            'reply_text'        => 'nullable|string|max:500',
            'failures'          => 'nullable|string|min:0',
            'search_text'       => 'nullable|string|max:255',
            'integration'       => 'nullable|string|max:255',
        ]);
        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


    }
}