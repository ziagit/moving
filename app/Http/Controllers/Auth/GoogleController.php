<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url'=>$url]);
    }
    public function handleGoogleCallback($provider){
        $user = Socialite::driver('google')->stateless()->user();
        if(!$user->token){
            dd('Failde');
        }
        $appUser = User::whereEmail($user->email)->first();
        if(!$appUser){
            $appUser = new User();
            $appUser->name = $user->name;
            $appUser->email = $user->email;
            $appUser->password = Hash::make('123');
            $appUser->save();
            $role = Role::where('name', '=', 'mover')->first();
            $appUser->roles()->attach($role);
            $token = Auth::login($appUser);
            return response()->json($token);
        }else{
            $socialAccount = SocialAccount::where('user_id',$appUser->id)
            ->where('provider',$provider)->first();
            if(!$socialAccount){
                $newSocialAccount = new SocialAccount();
                $newSocialAccount->provider= $provider;
                $newSocialAccount->provider_user_id = $user->id;
                $newSocialAccount->user_id = $appUser->id;
                $newSocialAccount->save();
            }
        }
        $token = Auth::login($appUser);
        return response()->json($token);
    }
}
