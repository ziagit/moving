<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function __invoke(Request $data)
    {
        $user = User::where('id', $data->me)->where('verification_code', $data->code)->first();
        if ($user) {
            $user->phone_verified_at = date('Y-m-d h:i:s');
            $user->update();
            $token = Auth::login($user);
            return response()->json($token);
        }
        return response()->json("Invalid code entered!", 404);


        /*         if ($data->type === "mover" || $data->type === "customer") {
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
                $user = User::create(array(
                    'name' => $data->name,
                    'email' => $data->email,
                    'password' => Hash::make($data->password),
                ));
                $role = Role::where('name', '=', $data->type)->first();
                $user->roles()->attach($role);

                if (!$token = Auth::attempt($data->only('email', 'password'))) {
                    return response()->json(null, 401);
                }
                return response()->json($token);
            } catch (Exception $e) {
                return $e->getCode();
            }
        } else {
            return response()->json(["message" => "Don't fuck with me 🖕"]);
        } */
    }
}
