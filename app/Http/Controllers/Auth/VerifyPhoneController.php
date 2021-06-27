<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller
{
    public function __invoke(Request $data)
    {
        
        $user = User::where('phone', $data->phone)->first();
        if ($user) {
            if ($user->status == 'Active') {
                $vcode = rand(1000, 9999);
                $user->verification_code = $vcode;
                $user->update();
                $this->sms($data, $vcode);
                return response()->json($user->id);
            } else {
                return response()->json('Your account is blocked by admin!', 404);
            }
        } else {
            $vcode = rand(1000, 9999);
            $user = User::create(array(
                'name' => $data->name,
                'phone' => $data->phone,
                'verification_code' => $vcode
            ));
            $role = Role::where('name', '=', $data->type)->first();
            $user->roles()->attach($role);
            $this->sms($data, $vcode);
            return response()->json($user->id);
        }
        return response()->json("Invalid phone number", 404);
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
