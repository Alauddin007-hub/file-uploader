<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FileController extends Controller
{
    public function index()
    {
        return Inertia::render('FileUploader');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Maximum 10GB file size
        ]);

        try {
            $file = $request->file('file');
            $uniqueId = Str::uuid(); // Generate unique ID
            $fileName = $uniqueId . '_' . $file->getClientOriginalName(); // Append unique ID to file name
            $filePath = $file->storeAs('uploads', $fileName); // Store file

            // Save file information to the database
            File::create([
                'unique_id' => $uniqueId,
                'file_name' => $fileName,
                'file_path' => $filePath,
            ]);

            return response()->json(['message' => 'File uploaded successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload file.'], 500);
        }
    }
}
