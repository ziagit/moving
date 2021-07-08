<?php

namespace App\Http\Controllers;

use App\Carrier;
use Exception;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function upload(Request $request)
    {
        $carrier = Carrier::find($request->refrence);
        if ($_FILES['file']) {
            $destination_dir = public_path('images/pub/');
            $base_filename = basename($_FILES["file"]["name"]);
            $temp = explode(".", $base_filename);
            $file_name = round(microtime(true)) . '.' . end($temp);
            $target_file = $destination_dir . $file_name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            if ($request->type == "insurance") {
                $carrier->insurance_papers = $file_name;
            }
            if ($request->type == "license") {
                $carrier->business_license = $file_name;
            }
            $carrier->update();
            return response()->json("Uploaded successfully!", 200);
        } else {
            return response()->json("File not exist");
        }
    
    }
}
