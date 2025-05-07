<?php

namespace App\Http\Controllers;
use App\Models\Blast;
use App\Models\BlastQuestion;
use App\Models\BlastAnswer;
use App\Models\Keyword;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlastController extends Controller
{
    //store the blast
    public function storeBlast(Request $request)
    {
    try {
        $validator = Validator::make($request->all(), [
            'blast_name' => 'required|string|max:255',
            'tempelate_id' => 'required_without:tempelate_structure|exists:tempelates,id',
            'tempelate_structure' => 'nullable|string',
            
            // Validation for array fields
            'send_platform' => 'required|array', // ensures it's an array and required
        
            'send_to_group_ids' => 'required|array', // ensures it's an array and required
        
            'keyword_ids' => 'nullable|array', // ensures it's an array, but it's optional
        
            'question_ids' => 'nullable|array', // ensures it's an array, but it's optional
        ]);
        

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ensure only one of 'tempelate_id' or 'tempelate_structure' is provided
        if ($request->has('tempelate_id') && $request->has('tempelate_structure')) {
            return redirect()->back()->withErrors([
                'error' => 'You can only provide either tempelate_id or tempelate_structure, not both.'
            ])->withInput();
        }
        
        $curr_userId = auth()->id();

        // Construct an associative array for insertion
        $newBlastData = [
            'blast_name' => $request->input('blast_name'),
            'user_id' => $curr_userId,
            'status' => $request->input('status', 'active') // Default status to 'active'
        ];

        if ($request->has('tempelate_id')) {
            $newBlastData['tempelate_id'] = $request->input('tempelate_id');
        } elseif ($request->has('tempelate_structure')) {
            $newBlastData['tempelate_structure'] = $request->input('tempelate_structure');
        }

        // Create a new record in the database
        $blast = Blast::create($newBlastData);

        // Return success response and redirect back with success message
        return redirect()->route('blast.index')->with('success', 'Blast created successfully');

    } catch (\Exception $e) {
        // Catch any exceptions and return back with the error message
        return redirect()->back()->withErrors([
            'error' => 'Something went wrong: ' . $e->getMessage()
        ])->withInput();
    }
}



    public function storeQuestions(Request $request){
         try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'question' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id|unique:blasts,id', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newQuestion = [
                'question' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
            ];


            // Create a new record in the database
            $addNewQuestion = BlastQuestion::create($newQuestion);

            if($addNewQuestion){
                return response()->json([
                    'message' => 'Question Added Successfully',
                    'status' => 'success',
                    'data' => $addNewQuestion,
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Question Not Added',
                    'status' => 'fail',
                   
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }  

    public function storeAnswere(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'answer' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id', 
                'contact_id' => 'required|integer|exists:ContactImportData,id', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newAnswer = [
                'answer' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
                'contact_id' => $request->input('contact_id'),
            ];


            // Create a new record in the database
            $addNewAnswer = BlastAnswer::create($newAnswer);

            if($addNewAnswer){
                return response()->json([
                    'message' => 'Answer Added Successfully',
                    'status' => 'success',
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Answer Not Added',
                    'status' => 'fail', 
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function storeKeyword(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'keyword' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newKeyword = [
                'keyword' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
            ];


            // Create a new record in the database
            $addNewKeyword = Keyword::create($newKeyword);

            if($addNewKeyword){
                return response()->json([
                    'message' => 'Keyword Added Successfully',
                    'status' => 'success',
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Keyword Not Added',
                    'status' => 'fail', 
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    
    
}
