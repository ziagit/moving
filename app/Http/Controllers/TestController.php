<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Events\NewMessage;
use App\Notifications\VerifyEmail;
use App\Test;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestController extends Controller
{
    public function testEvent(){
        try{
            event(new NewMessage('Hi from from Vuejs'));

        }catch(Exception $e){
            return $e->getMessage();
        }
       
    }
    public function index(){
       try{
        $admin = User::find(1);
        $x = $admin->notify(new VerifyEmail('O123455'));
        return response()->json($x);
       }catch(Exception $e){
           return response()->json($e->getMessage());
       }
    }
    public function store(Request $request){
        $test = new Test();
        $test->test = $request->test;
        $test->save();
        return response()->json(['message'=>'Saved successfully!'], 200);
    }
    public function destroy($id){
        $test = Test::find($id);
        $test->delete();
        return response()->json(['message'=>'Deleted successfully!'], 200);
    }

}
