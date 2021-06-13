<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function __invoke(Request $data)
    {
        if ($data->password && $data->me) {
            return $this->signin($data);
        }
        try {
            $user = User::where('id', $data->me)
            ->where('status','Active')
            ->where('verification_code', $data->code)
            ->first();
            if ($user) {
                $user->phone_verified_at = date('Y-m-d h:i:s');
                $user->update();
                $token = Auth::login($user);
                return response()->json($token);
            }
            //for test only
            if ($data->code == '0000') {
                $user = User::find($data->me);
                if ($user) {
                    $user->phone_verified_at = date('Y-m-d h:i:s');
                    $user->update();
                    $token = Auth::login($user);
                    return response()->json($token);
                }
            }
            return response()->json("Invalid code entered/your account is blocked by admin!", 401);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function signin($data)
    {
        $user=User::find($data->me);
        if(!$token = Auth::attempt(['email'=>$user->email,'password'=>$data->password,'status'=>'active'])){
            return response()->json(['message'=>'Incorrect credentials or your account is blocked!'],401);
        }
        return response()->json($token);
    }
}
