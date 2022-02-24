<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    // function to store file in 'upload' folder
    public function fileStore(Request $request)
    {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);

        $insert['title'] = $file_name;
        $check = Photo::insertGetId($insert);
        return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
    }
}
