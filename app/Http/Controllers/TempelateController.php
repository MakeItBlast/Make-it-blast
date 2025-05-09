<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tempelate;
use App\Models\UserResource;
use App\Models\ContactImportData;

use Illuminate\Support\Facades\Validator;


// new data
class TempelateController extends Controller
{
    // Get Template List
    public function getTempelate()
    {
        $curr_userId = auth()->id();
        $links = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'link')->get();

        $medias = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'image')->get();

        $tempelateList = Tempelate::where('user_id', $curr_userId)->get();
        
        return view('admin.pages.my-templates', compact('tempelateList','links', 'medias'));
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

            $links = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'link')->get();

            $medias = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'image')->get();

            return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList', 'links', 'medias'));
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
            // if (!$curr_userId) {
            //     return redirect()->back()->withErrors(['error' => 'User not authenticated']);
            // }

            $newTempelate = [
                'user_id' => $curr_userId,
                'template_structure' => $request->input('template_structure'),
                'template_by' => $request->input('tempelate_by'),
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
        try {
            $validator = Validator::make($request->all(), [
                'template_id' => 'required|integer',
                'template_structure' => 'required|string',
                'temp_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                //return redirect()->back()->withErrors($validator)->withInput();
            }

            $curr_userId = auth()->id();
            $temp_id = $request->input('template_id');

            $updTempelate = [
                'user_id' => $curr_userId,
                'template_structure' => $request->input('template_structure'),
                'template_by' => 'user',
                'temp_name' => $request->input('temp_name'),
            ];

            $updNewTempelate = Tempelate::where('id', $temp_id)
                ->where('user_id', $curr_userId)
                ->update($updTempelate);
            print_r($updNewTempelate);


            return redirect()->route('my-template')->with('success', 'Template updated successfully');
            if ($updNewTempelate > 0) {
                //return redirect()->route('admin.pages.update-templates')->with('success', 'Template updated successfully');
            } else {
                //return redirect()->route('admin.pages.update-templates')->with('error', 'No changes made to the template');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    // **Delete Template**
    //working for del
    //     public function deleteTempelate($id)
    // {
    //     try {
    //         $curr_userId = auth()->id();

    //         // Ensure the user owns the template before deleting
    //         $deleted = Tempelate::where('id', $id)
    //             ->where('user_id', $curr_userId)
    //             ->delete();

    //         return redirect()->back()->with(
    //             $deleted ? 'success' : 'error', 
    //             $deleted ? 'Template deleted successfully' : 'Failed to delete the template'
    //         );
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
    //     }
    // }

    // working for status
    public function deleteTempelate($id)
    {
        try {
            $curr_userId = auth()->id();

            // Find the template owned by the user
            $template = Tempelate::where('id', $id)
                ->where('user_id', $curr_userId)
                ->first();

            if (!$template) {
                return redirect()->back()->with('error', 'Template not found or access denied.');
            }

            // Toggle status between 'Active' and 'Inactive'
            $template->status = ($template->status === 'active') ? 'inactive' : 'active';
            $template->save();

            return redirect()->back()->with('success', 'Template status updated successfully.');
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

        //$resource = UserResource::where('user_id',$curr_userId)->get();

        $tempelateList = Tempelate::where('user_id', $curr_userId)->get();

        $links = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'link')->get();

        $medias = UserResource::where('user_id', $curr_userId)->where('rsrc_type', 'image')->get();

        // Retrieve the template
        $getTempelateStructure = Tempelate::where('id', $request->template)->first();

        return view('admin.pages.my-templates', compact('getTempelateStructure', 'tempelateList', 'userInfoColumns', 'links', 'medias'));
    }

    public function storeResourceLink(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'url_text' => 'required|string',
                'url_value' => 'required|url',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 200);
            }
    
            $newLink = UserResource::create([
                'user_id'    => auth()->id(),
                'rsrc_type'  => 'link',
                'rsrc_name'  => $request->input('url_text'),
                'rsrc_value' => $request->input('url_value'),
            ]);
    
            if ($newLink) {
                return response()->json([
                    'status' => true,
                    'message' => 'Link added successfully.',
                    'data' => $newLink
                ]);
            }
    
            return response()->json([
                'status' => false,
                'message' => 'Failed to add the link.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'details' => $e->getMessage()
            ], 200);
        }
    }




    public function storeResourceMedia(Request $request)
    {

  
        try {
            // 1. Validate input
            $validator = Validator::make($request->all(), [
                'media_text'  => 'required|string',
                'media_file'  => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,wmv|max:10240', // 10MB max
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 200);
            }
    
            // 2. Handle file upload
            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
    
                // Determine file type (image or video)
                $mimeType = $file->getMimeType();
                $isImage = str_starts_with($mimeType, 'image');
                $isVideo = str_starts_with($mimeType, 'video');
    
                $folder = $isImage ? 'user_resource/images' : ($isVideo ? 'user_resource/videos' : null);
    
                if (!$folder) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Unsupported media type.'
                    ], 200);
                }
    
                // Save file directly to the public folder
                $file->move(public_path($folder), $fileName);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'No media file uploaded.'
                ], 200);
            }
    
            // 3. Save to DB
            $newResource = UserResource::create([
                'user_id'    => auth()->id(),
                'rsrc_type'  => $isImage ? 'image' : 'video',
                'rsrc_name'  => $request->input('media_text'),
                'rsrc_value' => $folder . '/' . $fileName, // path relative to public/
            ]);
    
            if ($newResource) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Media uploaded successfully.',
                    'data'    => $newResource
                ]);
            }
    
            return response()->json([
                'status'  => false,
                'message' => 'Failed to upload media.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong.',
                'details' => $e->getMessage()
            ], 200);
        }
    }

    //delete media

    public function deleteResource(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'delId' => 'required|string|exists:user_resources,id',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
    
            $resource = UserResource::where('id', $request->delId)
            ->where('user_id', auth()->id())
            ->first();

            if ($resource) {
               $del_success =  $resource->delete();

                if($del_success){
                    return redirect()->back()->with('success', 'Resource deleted successfully.');

                }else{
                    return redirect()->back()->with('error', 'Resource not Deleted.'); 
                }

            } else {
                return redirect()->back()->with('error', 'Resource not found or already deleted.');
            }
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    
    
}
