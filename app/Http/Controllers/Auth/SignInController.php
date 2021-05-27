<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('id', $request->me)->where('verification_code', $request->code)->first();
        if ($user) {
            $token = Auth::login($user);
            return response()->json($token);
        }
        return response()->json("Invalid code entered!", 404);
    }
}
