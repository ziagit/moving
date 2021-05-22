<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Events\NewMessage;
use App\Test;
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
        $tests = Test::all();
        return response()->json($tests);
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
