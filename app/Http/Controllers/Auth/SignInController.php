<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        if(!$token = Auth::attempt(['email'=>$request['email'],'password'=>$request['password'],'status'=>'active'])){
            return response()->json(['message'=>'Incorrect credentials or your account is blocked!'],401);
        }
        return response()->json($token);

/*         if(!$token = Auth::attempt($request->only('email', 'password'))){
            return response()->json(['message'=>'The username or password is incorrect!'],401);
        }
        return response()->json($token); */
    }
}
