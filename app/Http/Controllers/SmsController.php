<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class SmsController extends Controller
{
    public function sendMessage(){
      
/*         $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to'   => '+93776994963',
            'from' => '+93793778030',
            'text' => 'Hi, from TingsApp, this is a test message.'
        ]); */
        return response()->json(['message'=>'COnfirmation message sent!']);
    }
}
