<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tempelate;
use App\Models\UserResource;
use App\Models\ContactImportData;

use Illuminate\Support\Facades\Validator;

// class TempelateController extends Controller
// {
//     //
//     public function storeTempelate(Request $request){

//         try {
//             $validator = Validator::make($request->all(), [
//                 'user_id' => 'required|integer|exists:users,id', // Ensures the user_id exists in the users table
//                 'tempelate_structure' => 'required|string',
//                 'tempelate_by' => 'required|string',
//                 'temp_name' => 'required|string|max:255|unique:templetes,temp_name', // Ensures temp_name is unique in the templetes table
//             ]);
            

//             if ($validator->fails()) {
//                 return redirect()->back()->withErrors($validator)->withInput();
//             }

//             // Construct an associative array for insertion
//             $newTempelate = [
//                 'user_id' => $request->input('user_id'),
//                 'tempelate_structure' => $request->input('tempelate_structure'),
//                 'tempelate_by' => $request->input('tempelate_by'),    
//                 'temp_name' => $request->input('temp_name'),                        
//             ];

           
//             // Create a new record in the database
//             $addNewTempelate = Tempelate::create($newTempelate);

//             if($addNewTempelate){
//                 return redirect()->back()->with('success', "Tempelate added successfully");
//             }else{
//                 return redirect()->back()->with('success', "Tempelate not added");
//             }

//         } catch (\Exception $e) {
//             return redirect()->back()
//                 ->withErrors(['error' => 'Some critical Error: ' . $e->getMessage()])
//                 ->withInput();
//         }
//     }

//     public function getTempelate(){

//         $curr_userId = auth()->id();
//         // Fetch all data from the Tempelate model
//         $tempelateList = Tempelate::where('user_id',$curr_userId)->get();

//         // Pass the data to the view
//         return view('admin.pages.my-templates',compact('tempelateList'));
//     }

//     public function getTempelateStructure(Request $request) {
//         try{
//         // Validate the request
//         $validator = Validator::make($request->all(), [
//             'template' => 'required|integer|exists:tempelates,id', // Validate against correct table
//         ]);
    
//         if ($validator->fails()) {
//             return redirect()->back()->withErrors($validator)->withInput();
//         }

//         $curr_userId = auth()->id();
//         // Fetch all data from the Tempelate model
//         $tempelateList = Tempelate::where('user_id',$curr_userId)->get();
    
//         // Retrieve the template
//         $getTempelateStructure = Tempelate::where('id', $request->template)->first();
//         echo '<pre>';
//         print_r($getTempelateStructure->temp_name);
//         echo '</pre>';
        
//         return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList'));
//      } catch (\Exception $e) {
//         // Handle exceptions and return a proper error message
//         return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
//     }
//     }
    
    
//     public function storeResource(Request $request){
//         try {
//             // Validate incoming request data
//             $validator = Validator::make($request->all(), [
//                 'rsrc_type' => 'required|string|max:255', // Assuming rsrc_type is a required string with a max length of 255
//                 'rsrc_name' => 'required|string|max:255', // Assuming rsrc_name is a required string with a max length of 255
//                 'user_id'   => 'required|integer|exists:users,id', // Assuming user_id is a required integer and must exist in the users table
//                 'blast_id'  => 'required|integer|exists:blasts,id', // Assuming blast_id is a required integer and must exist in the blasts table
//             ]);
            
           
//         if ($validator->fails()) {
//             return redirect()->back()->withErrors($validator)->withInput();
//         }

//             // Construct an associative array for insertion
//             $newResource = [
//                 'rsrc_type' => $request->input('rsrc_type'),
//                 'rsrc_name' => $request->input('rsrc_name'),
//                 'user_id' => $request->input('user_id'), 
//                 'blast_id' => $request->input('blast_id'),             
//             ];

           
//             // Create a new record in the database
//             $addNewResource = UserResource::create($newResource);

//             if($addNewResource){
//                 return redirect()->back()->with('success', "Resource added successfully"); 
//             }else{
//                 return redirect()->back()->with('success', "Resource not added");  
//             }

//         } catch (\Exception $e) {
//             // Handle exceptions and return a proper error message
//             return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
//         }
//     }

//     public function getResource(){
//         $curr_userId = auth()->id();

//         $resource = UserResource::all();

//         $tempelateList = Tempelate::where('user_id',$curr_userId)->get();
    
//         // Retrieve the template
//         $getTempelateStructure = Tempelate::where('id', $request->template)->first();

//         return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList','resource'));
//     }

// }



// new data
class TempelateController extends Controller
{
    // Get Template List
    public function getTempelate()
    {
        $curr_userId = auth()->id();
        $tempelateList = Tempelate::where('user_id', $curr_userId)->get();
        return view('admin.pages.my-templates', compact('tempelateList'));
    }

    // Get Template Structure and Populate Editor
    public function getTempelateStructure(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'template' => 'required|integer|exists:tempelates,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $curr_userId = auth()->id();
            $tempelateList = Tempelate::where('user_id', $curr_userId)->get();
            $getTempelateStructure = Tempelate::where('id', $request->template)->first();

            // Return view with template structure populated
            return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    // Store New Template
    public function storeTempelate(Request $request)
    {
    try {
        $validator = Validator::make($request->all(), [
            'template_structure' => 'required|string',
            'tempelate_by' => 'required|string',
            'temp_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $curr_userId = auth()->id();
        if (!$curr_userId) {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }

        $newTempelate = [
            'user_id' => $curr_userId,
            'template_structure' => $request->input('template_structure'),
            'tempelate_by' => $request->input('tempelate_by'),
            'temp_name' => $request->input('temp_name'),
        ];

        $addNewTempelate = Tempelate::create($newTempelate);

        if ($addNewTempelate) {
            return redirect()->back()->with('success', 'Template added successfully');
        } else {
            return redirect()->back()->with('error', 'Template not added');
        }
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
    }
}


    public function updateTempelatStructure(Request $request)
    {
        print_r($request->template_id);
       
        try {
            $validator = Validator::make($request->all(), [
                'template_id' => 'required|integer',
                'template_structure' => 'required|string',
                'tempelate_by' => 'required|string',
                'temp_name' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $curr_userId = auth()->id();
            $temp_id = $request->input('template_id');
    
            $newTempelate = [
                'user_id' => $curr_userId,
                'template_structure' => $request->input('template_structure'),
                'tempelate_by' => $request->input('tempelate_by'),
                'temp_name' => $request->input('temp_name'),
            ];
    
            $updNewTempelate = Tempelate::where('id', $temp_id)
                ->where('user_id', $curr_userId)
                ->update($newTempelate);
    
            if ($updNewTempelate > 0) {
                return redirect()->back()->with('success', 'Template updated successfully');
            } else {
                return redirect()->back()->with('error', 'No changes made to the template');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    

    // Fetch User Resources (Optional)
    // public function getResource()
    // {
    //     $curr_userId = auth()->id();
    //     $resource = UserResource::all();
    //     $tempelateList = Tempelate::where('user_id', $curr_userId)->get();
    //     return view('admin.pages.my-templates', compact('resource', 'tempelateList'));
    // }

    public function getResource()
    {
                $curr_userId = auth()->id();

                //$userInfoColumns = ContactImportData::where('user_id',$curr_userId)->get();
        
                $resource = UserResource::where('user_id',$curr_userId)->get();
        
                $tempelateList = Tempelate::where('user_id',$curr_userId)->get();
            
                // Retrieve the template
                $getTempelateStructure = Tempelate::where('id', $request->template)->first();
        
                return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList','resource','userInfoColumns'));
            }
}