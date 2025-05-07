<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Validator;
class SupportTicketController extends Controller
{

  

    public function getSupportData(){

       
        $curr_userId = auth()->id();
        // Fetch only required columns (optional, depending on your needs)
        $getSupportData = SupportTicket::where('user_id', $curr_userId)->get();

    
        return view('admin.pages.contact', compact('getSupportData'));
    }


    function generateTicketId($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; 
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

}
