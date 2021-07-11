<?php

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;
use App\Role;
use App\SocialAccount;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MobileSocialLoginController extends Controller
{
    public function login(Request $request)
    {
        try{
            $user = User::whereEmail($request->email)->first();
            if (!$user) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make('123');
                $user->email_verified_at = date('Y-m-d h:i:s');
                $user->save();
                $role = Role::where('name', '=', $request->type)->first();
                $user->roles()->attach($role);
                $token = Auth::login($user);
                return response()->json($token);
            }
            $socialAccount = SocialAccount::where('user_id', $user->id)
                ->where('provider', $request->provider)->first();
            if (!$socialAccount) {
                $newSocialAccount = new SocialAccount();
                $newSocialAccount->provider = $request->provider;
                $newSocialAccount->provider_user_id = $user->id;
                $newSocialAccount->user_id = $user->id;
                $newSocialAccount->save();
            }
            $token = Auth::login($user);
            return response()->json($token);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    
    }
}
