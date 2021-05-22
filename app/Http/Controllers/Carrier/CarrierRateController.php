<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use App\Rate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class CarrierRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $rate = Rate::where('carrier_id', $carrierId)->first();
        return response()->json($rate);
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
    public function show($id)
    {
        $rate = Rate::find($id);
        return response()->json($rate);
    }

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
        $rate = Rate::find($id);
        if(!$rate){
            $rate = new Rate();
            $rate->price = $request->price;
            $rate->carrier_id = User::with('carrier')->find(Auth::id())->carrier->id;
            $rate->save();
            return response()->json(["message" => "Saved successfully!"]);
        }
        $rate->price = $request->price;
        $rate->update();
        return response()->json(["message" => "Updated successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = Rate::find($id);
        $rate->delete();
        return response()->json(["message" => "Deleted successfully!"]);
    }
}
