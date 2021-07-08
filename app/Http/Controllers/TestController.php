<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Events\NewMessage;
use App\Http\Services\Services;
use App\Http\Services\Sms;
use App\Mail\JobCanceled;
use App\Mail\OrderUpdated;
use App\Notifications\VerifyEmail;
use App\Test;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use SignalWire\Rest\Client;

class TestController extends Controller
{
    public function index(Request $request)
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

    public function testEvent()
    {
        try {
            event(new NewMessage('Hi from from Vuejs'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $test = new Test();
        $test->test = $request->test;
        $test->save();
        return response()->json(['message' => 'Saved successfully!'], 200);
    }
    public function destroy($id)
    {
        $test = Test::find($id);
        $test->delete();
        return response()->json(['message' => 'Deleted successfully!'], 200);
    }
}
