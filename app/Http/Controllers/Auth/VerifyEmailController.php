<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $data)
    {
        if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            //register by email
            return $this->byEmail($data);
        } else {
            //register by phone
            return $this->byPhone($data);
            $parts = sscanf($data->email, '%2c%3c%3c%4c');
            return "$parts[1]-$parts[2]-$parts[3]";
        }
        return response()->json("Invalid data provided!", 404);
    }
    public function byPhone($data)
    {
        $user=User::where('phone',$data->email)->first();
        if($user){
            return response()->json(['error' => "This phone number is already taken!"], 409);
        }
        try {
            if ($this->validate_phone_number($data->email) == true) {
                $vcode = rand(1000, 9999);
                $user = User::create(array(
                    'name' => $data->name,
                    'phone' => $data->email,
                    'password' => Hash::make($data->password),
                    'verification_code' => $vcode
                ));
                $role = Role::where('name', '=', $data->type)->first();
                $user->roles()->attach($role);
                $this->sms($data, $vcode);
                return response()->json($user->id);
            }
            return response()->json("Please provide valid information!", 203);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function byEmail($data)
    {
        $validator = Validator::make($data->only('email'), [
            'email' => 'unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 409);
        }

        $validator = Validator::make($data->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($data->type === "mover") {
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            try {
                $vcode = rand(1000, 9999);
                $user = User::create(array(
                    'name' => $data->name,
                    'email' => $data->email,
                    'password' => Hash::make($data->password),
                    'verification_code' => $vcode
                ));
                $role = Role::where('name', '=', $data->type)->first();
                $user->roles()->attach($role);
                //$user->notify(new VerifyEmail($vcode));
                return response()->json($user->id);
            } catch (Exception $e) {
                return $e->getCode();
            }
        } else {
            return response()->json(["message" => "Don't fuck with me 🖕"]);
        }
    }
    public function sms($data, $vcode)
    {
        try {
            $nexmo = app('Nexmo\Client');
            return $nexmo->message()->send([
                'to'   => $data->email,
                'from' => '+93793778030',
                'text' => 'TingsApp, Your Verification code is: ' . $vcode
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    function validate_phone_number($phone)
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);

        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }
}
