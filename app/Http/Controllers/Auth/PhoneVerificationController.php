<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneVerificationController extends Controller
{
    public function getCode(Request $request)
    {
        $nexmo = app('Nexmo\Client');
        /*  $verification = $nexmo->verify()->start([
                'number' => '+93793778030',
                'brand'  => 'Laravel Demo'
            ]); */
        $request->session()->put('verify:request_id', '123');
        return response()->json(['code' => "4567",], 200);
    }
    public function verify(Request $request)
    {
        $this->validate($request, [
            'code' => 'size:4',
        ]);

          /*   $nexmo = app('Nexmo\Client');
            $nexmo->verify()->check(
                $request->session()->get('verify:request_id'),
                $request->code
            ); */
            Auth::loginUsingId($request->session()->pull('verify:user:id'));
            return response()->json(['Message' => "Verified successfully",], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*   public function show($id)
    {
        //
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
