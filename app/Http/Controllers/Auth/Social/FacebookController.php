<?php

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;
use App\Role;
use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirect(){
        $url = Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url'=>$url]);
    }
    public function callback(){
        $user = Socialite::driver('facebook')->stateless()->user();
        if(!$user->token){
            dd('Failde');
        }
        $appUser = User::whereEmail($user->email)->first();
        if(!$appUser){
            $appUser = new User();
            $appUser->name = $user->name;
            $appUser->email = $user->email;
            $appUser->password = Hash::make('123');
            $appUser->email_verified_at = date('Y-m-d h:i:s');
            $appUser->save();
            $role = Role::where('name', '=', 'mover')->first();
            $appUser->roles()->attach($role);
            $token = Auth::login($appUser);
            return view('socilacallback')->with('token',$token);
        }else{
            $socialAccount = SocialAccount::where('user_id',$appUser->id)
            ->where('provider','facebook')->first();
            if(!$socialAccount){
                $newSocialAccount = new SocialAccount();
                $newSocialAccount->provider= 'facebook';
                $newSocialAccount->provider_user_id = $user->id;
                $newSocialAccount->user_id = $appUser->id;
                $newSocialAccount->save();
            }
        }
        $token = Auth::login($appUser);
        return view('socilacallback')->with('token',$token);
    }
}
