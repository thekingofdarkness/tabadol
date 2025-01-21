<?php

namespace App\Http\Controllers\Blog;

use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validate the request to ensure an image file is provided
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Handle the uploaded file
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');
            //saving path to db for feature upgrades
            $imageDB = new ImageUpload();
            $imageDB->path = $path;
            $imageDB->save();

            // Return the image URL
            return response()->json([
                'success' => true,
                'url' => Storage::url($path),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image upload failed.',
        ], 500);
    }
}
