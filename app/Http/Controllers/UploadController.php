<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Store the image in public/uploads folder
        $path = $request->file('file')->store('uploads', 'public');

        // Return the URL to the uploaded image
        return response()->json(asset('storage/' . $path));
    }
}
