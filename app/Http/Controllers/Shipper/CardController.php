<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomer()
    {
        $customerId = Auth::user()->customer_id;
        if ($customerId) {
            $card = Stripe::cards()->all($customerId);
            return response()->json($card);
        } else {
            return null;
        }
    }
    public function getCharges()
    {
        $shipper = User::with('shipper')->find(Auth::id())->shipper;
        $orders = Order::where('shipper_id',$shipper->id)->orderBy('id','DESC')->get();
return $orders;

        $res= array();
        $customerId = Auth::user()->customer_id;
        $charges = Stripe::charges()->all(['customer'=>$customerId]);
        for($i =0; $i< count($orders);$i++){
            if($orders[$i]['charge_id'] == $charges['data'][$i]['id']){
                $res[$i]['order'] =$orders[$i]['uniqid'];
                $res[$i]['amount'] =$orders[$i]['uniqid'];
            }

        }
        if ($customerId) {
            $card = Stripe::cards()->all($customerId);
            return response()->json($card);
        } else {
            return null;
        }
    }

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
    public function show($id)
    {
        //
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
