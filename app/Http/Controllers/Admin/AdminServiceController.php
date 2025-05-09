<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller

use App\Models\Service;
use App\Models\SystemValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminServiceController extends Controller
{
//     /**
//      * Store a new service
//      */
public function storeOrUpdateService(Request $request)
{
    try {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'service_name'    => 'required|string|max:255',
            'service_desc'    => 'nullable|string|max:500',
            
            'yearly_discount' => 'required|numeric',
            'cost_per_blast'  => 'required|numeric',
            'id'              => 'nullable|integer|exists:services,id', // For update
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if it's an update or create operation
        if ($request->filled('id')) {
            // Update existing service
            $service = Service::find($request->id);

            $service->update([
                'service_name'      => $request->service_name,
                'service_desc'      => $request->service_desc,
                'system_value_id'   => $request->system_value_id,
                'flat_rate'         => $request->has('flat_rate') ? 'active' : 'inactive',
                'status'            => $request->has('status') ? 'active' : 'inactive',
                'yearly_discount'   => $request->yearly_discount,
                'cost_per_blast'    => $request->cost_per_blast,
            ]);
            return redirect()->back()->with('success', 'Service updated successfully.');
        } else {
            // Create new service
            $addNewService = Service::create([
                'service_name'    => $request->service_name,
                'service_desc'    => $request->service_desc,
                'system_value_id' => $request->system_value_id,
                'flat_rate'         => $request->has('flat_rate') ? 'active' : 'inactive',
                'status'            => $request->has('status') ? 'active' : 'inactive',
                'yearly_discount' => $request->yearly_discount,
                'cost_per_blast'    => $request->cost_per_blast,
            ]);

            return $addNewService
                ? redirect()->back()->with('success', 'New Service added successfully.')
                : redirect()->back()->with('error', 'Failed to add Service.');
        }

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
}


    /**
     * Get all services
     */
    public function getService(Request $request)
    {
        // return view('admin.pages.create-services');
        try {

            $getService = Service::all();
            $updServiceData = Service::find($request->id);
    
            if ($updServiceData) {
                $updServiceData->credit_cost_autofill = $updServiceData->cost_per_blast * env('DOLLAR_VALUE', 1);
            }

            return view('admin.pages.create-services', compact('getService','updServiceData'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve services: ' . $e->getMessage()]);
        }
    }

    //populate data for update
    // public function populateServiceData(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'id' => 'required|integer|exists:services,id',
    //         ]);
    
    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $getService = Service::all();
    
    //         $updServiceData = Service::find($request->id);
    
    //         if ($updServiceData) {
    //             $updServiceData->credit_cost_autofill = $updServiceData->cost_per_blast * env('DOLLAR_VALUE', 1);
    //         }
    
    //         return view('admin.pages.create-services', compact('updServiceData','getService'));
    
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    //     }
    // }

    public function toggleServiceStatus(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:services,id',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            // Fetch the service
            $service = Service::findOrFail($request->id);
    
            // Toggle the status
            $service->status = $service->status === 'active' ? 'inactive' : 'active';
            $service->save();
    
            // Return a JSON response with status and message
            return response()->json([
                'success' => true,
                'message' => 'Service status updated successfully.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);

        }
    }
    

    /**
     * Update a service
     */
    // public function updateService(Request $request, $id)
    // {
    //     try {
    //         // Validate request data
    //         $validator = Validator::make($request->all(), [
    //             'service_name'    => 'required|string|max:255',
    //             'service_desc'    => 'nullable|string|max:500',
    //             'system_value_id' => 'required|integer|exists:system_values,id',
    //             'flat_rate'       => 'required|numeric|min:0',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $service = Service::findOrFail($id);
    //         $service->update([
    //             'service_name'    => $request->service_name,
    //             'service_desc'    => $request->service_desc,
    //             'system_value_id' => $request->system_value_id,
    //             'flat_rate'       => $request->flat_rate,
    //         ]);

    //         return redirect()->back()->with('success', 'Service updated successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    //     }
    // }

    /**
     * Delete a service
     */
    public function deleteService(Request $request)
    {
       // print_r($request->$delId);
        try {

            $validator = Validator::make($request->all(), [
                'delId' => 'required|integer|exists:services,id',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $service = Service::find($request->delId);
            $service->delete();

            return redirect('create-services')->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete service: ' . $e->getMessage(). $e->getLine()]);
        }
    }

    /**
     * Store a new system value
     */
    // public function storeSystemValue(Request $request)
    // {
    //     try {
    //         // Validate request data
    //         $validator = Validator::make($request->all(), [
    //             'yearly_discount' => 'required|numeric|between:0,100',
    //             'cost_per_blast'  => 'required|numeric|min:0',
    //             'dollar_value'    => 'required|numeric|min:0',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $addNewSystemValue = SystemValue::create([
    //             'yearly_discount' => $request->yearly_discount,
    //             'cost_per_blast'  => $request->cost_per_blast,
    //             'dollar_value'    => $request->dollar_value,
    //         ]);

    //         return $addNewSystemValue
    //             ? redirect()->back()->with('success', 'System value added successfully.')
    //             : redirect()->back()->with('error', 'Failed to add system value.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    //     }
    // }

    /**
     * Get all system values
     */
    // public function getSystemValue()
    // {
    //     try {
    //         $getSystemValues = SystemValue::all();
    //         return view('admin.pages.profile', compact('getSystemValues'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to retrieve system values: ' . $e->getMessage()]);
    //     }
    // }

    /**
     * Update a system value
     */
    // public function updateSystemValue(Request $request, $id)
    // {
    //     try {
    //         // Validate request data
    //         $validator = Validator::make($request->all(), [
    //             'yearly_discount' => 'required|numeric|between:0,100',
    //             'cost_per_blast'  => 'required|numeric|min:0',
    //             'dollar_value'    => 'required|numeric|min:0',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $systemValue = SystemValue::findOrFail($id);
    //         $systemValue->update([
    //             'yearly_discount' => $request->yearly_discount,
    //             'cost_per_blast'  => $request->cost_per_blast,
    //             'dollar_value'    => $request->dollar_value,
    //         ]);

    //         return redirect()->back()->with('success', 'System value updated successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    //     }
    // }

    /**
     * Delete a system value
     */
    // public function deleteSystemValue($id)
    // {
    //     try {
    //         $systemValue = SystemValue::findOrFail($id);
    //         $systemValue->delete();

    //         return redirect()->back()->with('success', 'System value deleted successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to delete system value: ' . $e->getMessage()]);
    //     }
    // }
}
