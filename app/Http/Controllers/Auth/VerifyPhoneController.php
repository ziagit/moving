<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller
{
    public function __invoke(Request $data)
    {
        /*    $nexmo = app('Nexmo\Client');
        $verification = $nexmo->verify()->start([
            'number' => $user->phone,
            'brand'  => 'TingsApp Demo'
        ]); */
        /*       $validator = Validator::make($data->only('phone'), [
                'phone' => 'unique:users',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 409);
            } */

        $user = User::where('phone', $data->phone)->first();
        if ($user) {
            if ($user->status == 'active') {
                $vcode = rand(1000, 9999);
                $user->verification_code = $vcode;
                $user->update();
                /*       $nexmo = app('Nexmo\Client');
                    $nexmo->message()->send([
                        'to'   => $data->phone,
                        'from' => '+93793778030',
                        'text' => 'TingsApp, Your Verification code is: ' . $vcode
                    ]); */
                return response()->json($user->id);
            }else{
                return response()->json('Your account is blocked by admin!',404);
            }
        } else {
            $vcode = rand(1000, 9999);
            $user = User::create(array(
                'name' => "Customer",
                'phone' => $data->phone,
                'verification_code' => $vcode
            ));
            $role = Role::where('name', '=', 'customer')->first();
            $user->roles()->attach($role);

            /*             $nexmo = app('Nexmo\Client');
                $nexmo->message()->send([
                    'to'   => $data->phone,
                    'from' => '+93793778030',
                    'text' => 'TingsApp, Your Verification code is: ' . $vcode
                ]); */
            return response()->json($user->id);
        }
        return response()->json("Invalid phone number", 404);
    }
}
