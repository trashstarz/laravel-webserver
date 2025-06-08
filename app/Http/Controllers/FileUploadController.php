<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Http\Request;


class FileUploadController extends Controller
{
    public function uploadFile(Request $request) {
        $request->validate([
            'file' => 'required|file|max:4096'
        ]);

        //grab uploaded file as an object to access laravels methods
        $file = $request->file('file');

        $path = $request->file('file')->store('uploads', 'public');

        UploadedFile::create([
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect('/');

    }
}
