<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
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
    public function byPhone($data){
        try{
            $user = User::where('id', $data->me)->where('verification_code', $data->code)->first();
            if ($user) {
                $user->phone_verified_at = date('Y-m-d h:i:s');
                $user->update();
                $token = Auth::login($user);
                return response()->json($token);
            }
            //for test only
            if($data->code == '0000'){
                $user = User::where('id', $data->me)->first();
                if ($user) {
                    $user->phone_verified_at = date('Y-m-d h:i:s');
                    $user->update();
                    $token = Auth::login($user);
                    return response()->json($token);
                }
            }
            return response()->json("Invalid code entered!", 404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function byEmail($data)
    {
        if ($data->type === "mover") {
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
                $user->notify(new VerifyEmail($vcode));
/*                 if (!$token = Auth::attempt($data->only('email', 'password'))) {
                    return response()->json(null, 401);
                } */
                return response()->json($user->id);
            } catch (Exception $e) {
                return $e->getCode();
            }
        } else {
            return response()->json(["message" => "Don't fuck with me 🖕"]);
        }
    }
}
