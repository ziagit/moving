<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function forget(Request $request)
    {

        $validator = Validator::make($request->only('email'), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        if (!$user = User::where('status', 'active')->where('email', $request->email)->first()) {
            return response()->json(['message' => 'Invalid email!'], 401);
        }

        try {
            $vcode = rand(1000, 9999);
            $user->verification_code = $vcode;
            $user->update();
            //send email
            Mail::to($request->email)->queue(new PasswordReset($vcode));
            return response([
                'message' => 'Email sent check your inbox',
                'email' => $user->email
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
    public function verify(Request $request)
    {
        try {
            $user = User::whereEmail($request->email)
                ->where('verification_code', $request->code)
                ->first();
            if (!$user) {
                return response()->json(['error' => 'Invalid code!'], 400);
            }
            return response()->json($user);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return response()->json(["error"=>"Invalid email!"],400);
        }
        $user->password = Hash::make($request->password);
        $user->update();
        return response([
            'message' => 'Your password reset successfully!'
        ], 200);
    }
}
