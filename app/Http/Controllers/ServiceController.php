<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\SystemValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function storeService(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'service_name'      => 'required|string|max:255', // Ensures it's a required string with max length of 255
                'service_desc'      => 'nullable|string|max:500', // Optional string with max length of 500
                'system_value_id'   => 'required|integer|exists:system_values,id', // Required integer that must exist in the system_values table
                'flat_rate'         => 'required|numeric|min:0', // Required numeric value, must be greater than or equal to 0
            ]);
             
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    


            // Construct an associative array for insertion
            $newService = [
                'service_name' => $request->input('service_name'),
                'service_desc' => $request->input('service_desc'),
                'system_value_id' => $request->input('system_value_id'),
                'flat_rate' => $request->input('flat_rate'),
            ];

           
            // Create a new record in the database
            $addNewService = Service::create($newService);

            if($addNewService){
                return redirect()->back()->with('success', "New Service added successfully");
            }else{
                return redirect()->back()->with('success', "Service Not Added");
            }

        } catch (\Exception $e) {
          
        }
    }

    //get services 
    public function getService(){

        $getService = Service::all();
        
         
         return view('admin.pages.profile', compact('getService'));
    }

    //store system values
    public function storeSystemValue(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'yearly_discount'    => 'required|numeric|between:0,100', // Ensures it is a numeric value between 0 and 100
                'cost_per_blast'     => 'required|numeric|min:0', // Ensures it is a numeric value greater than or equal to 0
                'dollar_value'       => 'required|numeric|min:0', // Ensures it is a numeric value greater than or equal to 0
            ]);
            

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            // Construct an associative array for insertion
            $newSystemValue = [
                'yearly_discount' => $request->input('yearly_discount'),
                'cost_per_blast' => $request->input('cost_per_blast'),
              'dollar_value' => $request->input('dollar_value'),
                
            ];

           
            // Create a new record in the database
            $addNewSystemValue = SystemValue::create($newSystemValue);

            if($addNewSystemValue){
                return redirect()->back()->with('success', "system value added Successcully");
            }else{
                return redirect()->back()->with('success', "system value not added");
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Some critical Error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function getSystemValue(){
        
        $getSystemValues = SystemValue::all();
        
         
         return view('admin.pages.profile', compact('getSystemValues'));
    }
    
}
