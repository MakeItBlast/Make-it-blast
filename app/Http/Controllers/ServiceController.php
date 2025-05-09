<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\SystemValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function storeService(Request $request) {
        try {
            // Check if it's an update (id present) or create
            $isUpdate = $request->has('id');
    
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'service_name'      => 'required|string|max:255',
                'service_desc'      => 'nullable|string|max:500',
                'system_value_id'   => 'required|integer|exists:system_values,id',
                'flat_rate'         => 'required|numeric|min:0',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            // Prepare data array
            $serviceData = [
                'service_name'     => $request->input('service_name'),
                'service_desc'     => $request->input('service_desc'),
                'system_value_id'  => $request->input('system_value_id'),
                'flat_rate'        => $request->input('flat_rate'),
            ];
    
            if ($isUpdate) {
                $service = Service::find($request->input('id'));
                if (!$service) {
                    return redirect()->back()->with('error', "Service not found");
                }
                $service->update($serviceData);
                return redirect()->back()->with('success', "Service updated successfully");
            } else {
                $newService = Service::create($serviceData);
                if ($newService) {
                    return redirect()->back()->with('success', "New Service added successfully");
                } else {
                    return redirect()->back()->with('error', "Service not added");
                }
            }
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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
