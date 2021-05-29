<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
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
    }
}
