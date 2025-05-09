<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\IssueType;
use Illuminate\Support\Facades\Validator;
class SupportTicketController extends Controller
{

  

    public function getSupportData(){

        //$populateUpdate = IssueType::find($request->updId);

        $curr_userId = auth()->id();
        // Fetch only required columns (optional, depending on your needs)
        $getSupportData = SupportTicket::where('user_id', $curr_userId)->with('issueType')->get();
        $getIssueData = IssueType::where('status','active')->get();
    
    
        return view('admin.pages.contact', compact('getSupportData','getIssueData'));
    }


    
    public function getIssueTypes(Request $request){

        //admin
        $populateUpdate = IssueType::find($request->updId);

        $getSupportData = SupportTicket::with('issueType')->get();
        $getIssueTypes = IssueType::all();
    
        return view('admin.pages.ticket', compact('getIssueTypes','getSupportData','populateUpdate'));
    }

    function generateTicketId($length = 10) {
        $characters = '0123456789'; 
        $ticket_id = '';
        for ($i = 0; $i < $length; $i++) {
            $ticket_id .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $ticket_id;
    }
    

    // In SupportTicketController.php
public function storeSupportTicket(Request $request)
{
    //print_r($request);
    try {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',                      // title should be required, a string, and have a max length of 255
            'message'           => 'required|string',                               // message should be required and a string
            'priority'          => 'required|in:low,medium,high',                 // priority should be one of the values: low, medium, or high
            'supporting_image'  => 'required|image|mimes:jpeg,png,jpg|max:2048', // supporting_image is optional, but if provided it should be an image with specific formats and max size of 2MB
            'issue_type'        => 'required|numeric',
        ]);

      
        // If validation fails, return a response with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the current user ID
        $curr_userId = auth()->id();
        //print_r($curr_userId);
      
      
        $ticket_id = $this->generateTicketId(); 
        // Prepare the data for insertion

          // Handle the file upload (if provided)
          if ($request->supporting_image) {
          
            // Generate a unique name for the image
            $imageName = time().'.'.request()->supporting_image->getClientOriginalExtension();
               
            // Move the image to the public directory
            $imagePath = request()->supporting_image->move(public_path('support_ticket_images'), $imageName);
          
            }else{
                $request->supporting_image = "";
            }

        $newSupportTicket = [
            'title' => $request->input('title'),
            'ticket_id' => $ticket_id,
            'message' => $request->input('message'),
            'priority' => $request->input('priority'),
            'user_id' => $curr_userId,
            'problem_type' => $request->input('issue_type'),
        ];
        $newSupportTicket['supporting_image'] = $imageName;

        // Create a new support ticket record in the database
        $addNewSupportTicket = SupportTicket::create($newSupportTicket); // Assuming the model is SupportTicket

        if ($addNewSupportTicket) {
            return redirect()->back()->with('success', 'Support ticket created successfully!');
        } else {
            return redirect()->back()->withErrors('Failed to create the support ticket.')->withInput();
        }
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
    }
}


public function addIssueType(Request $request)
{
    try {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'issue_type' => 'required|string|max:255|unique:issue_types,issue_type',
        ]);        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare data for insert or update
        $data = [
            'issue_type' => $request->input('issue_type'),
            'status'     => 'active',
        ];

        // Check if we're updating or creating
        if ($request->has('updId') && !empty($request->input('updId'))) {
            $issueType = IssueType::find($request->input('updId'));

            if (!$issueType) {
                return redirect()->back()->withErrors('Issue type not found.')->withInput();
            }

            $upd = $issueType->update($data);

                if($upd){
                    return redirect()->back()->with('success', 'Issue type updated successfully!');
                }else{
                    return redirect()->back()->with('error', 'Issue type not updated');
                }

           
        } else {
            IssueType::create($data);

            return redirect()->back()->with('success', 'Issue type created successfully!');
        }

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
    }
}

public function deleteIssueType(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'delId' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $issueType = IssueType::find($request->delId);

        if ($issueType) {
            // Check if there are any related SupportTicket records
            $relatedTickets = SupportTicket::where('problem_type', $issueType->id)->exists();

            if ($relatedTickets) {
                // If related tickets exist, return a message
                return redirect()->back()->withErrors(['error' => 'This issue type cannot be deleted as it is associated with existing tickets.'])->withInput();
            }

            // If no related records, delete the IssueType
            $issueType->delete();
            return redirect()->back()->with('success', 'Issue type deleted successfully!');
        } else {
            return redirect()->back()->withErrors(['error' => 'Issue type not found.'])->withInput();
        }

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
    }
}


public function updateIssueType(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $issueType = IssueType::find($request->id);

        if(!$issueType){
            $data = [
                'status' => 200,
                'message' => 'id not found',
            ];
            return response()->json($data);
        }

        if($issueType->status == 'active'){
            $chk = $issueType->update(['status'=>'inactive']);
        }else{
            $chk = $issueType->update(['status'=>'active']);
        }

        if($chk){
            $data = [
                'status' => 'success',
                'message' => 'updated successfully',
            ];
        }else{
            $data = [
                'status' => 500,
                'message' => 'failed to update',
            ];
        }
       

        return response()->json($data);
        // if ($chk) {
        //     return redirect()->back()->with('success', 'Issue type deleted successfully!');
        // } else {
        //     return redirect()->back()->withErrors(['error' => 'Issue type not found.'])->withInput();
        // }

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
    }
}


public function updateSupportStatus(Request $request)
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
 
        $upd = SupportTicket::find($request->id); // <-- Corrected line
 
        if (!$upd) {
            return response()->json([
                'status' => 200,
                'message' => 'id not found',
            ]);
        }
 
        $newStatus = $upd->status === 'closed' ? 'open' : 'closed';
 
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
