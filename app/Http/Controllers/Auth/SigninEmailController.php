<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;

class SigninEmailController extends Controller
{
    //

    public function __invoke(Request $data)
    {
        if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email',$data->email)->first();
            if($user){
                return response()->json(['status'=>'email','id'=>$user->id],200);
            }
            return response()->json("This email not found!",404);
        } else {
            $user = User::where('phone',$data->email)->first();
            if($user){
                $vcode = rand(1000, 9999);
                $user->verification_code =$vcode;
                $user->update();
                $this->sms($data->email, $vcode);
                return response()->json(['status'=>'phone','id'=>$user->id]);
            }
            return response()->json("Invalide phone number!",404);
        }
    }
    public function sms($data, $vcode)
    {
        try{
            $nexmo = app('Nexmo\Client');
            return $nexmo->message()->send([
                'to'   => $data->phone,
                'from' => '+93793778030',
                'text' => 'TingsApp, Your Verification code is: ' . $vcode
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
   
    }
}
