<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Earning;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unpaid()
    {
        //['moving_cost','travel_cost','supplies_cost','paid_gst','carrier_earning']
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $earnings = Earning::with('order')
            ->where('carrier_id', $carrierId)
            ->where('status', 'unpaid')
            ->paginate(10);
        return response()->json($earnings);
    }
    public function paid()
    {
        //['moving_cost','travel_cost','supplies_cost','paid_gst','carrier_earning']
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $earnings = Earning::with('order')
            ->where('carrier_id', $carrierId)
            ->where('status', 'paid')
            ->paginate(5);
        return response()->json($earnings);
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
        $earning = Earning::with('order')
            ->find($id);
        return response()->json($earning);
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
