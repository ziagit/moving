<?php

namespace App\Http\Controllers\Shipper;

use App\Carrier;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrier = Carrier::with('fullAddress','contact')->get();
        return response()->json($carrier);
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
        return "hi";
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
        $order = Order::with('job')->find($id);     
        $order->tips=$request->tips;
        $order->update();
        $carrier = Carrier::find($order->job->carrier_id); 
        $carrier->votes = $carrier->votes + $request->ratting/10;
        $carrier->update();
        $this->processPayment($request,$id);
        return response()->json([
            'message'=>'Thanks, for ratting and reviews!'
        ],200);
    }
    public function processPayment($request, $id){
        $order = Order::find($id);
        $shipper = Shipper::find($order->shipper_id);
        $cost = $order->cost + $request->tips;
        $charge = Stripe::charges()->create([
            'amount' => $cost,
            'currency' => 'USD',
            'description' => 'Moving payment',
            'customer' => $shipper->stripe_customer_id
        ]);
        $order->charge_id = $charge['id'];
        $order->update();
        return true;
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
