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
    public function index()
    {
        Mail::to('zia.googl@gmail.com')->queue(new JobCanceled(1));
        return "email sent";
        $sms = new Sms();
        $res = $sms->verify("+16049876543", "1234");
        if ($res->status == 'failed') {
            return response()->json($res->errorMessage, 400);
        }
        return $res->status;
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
