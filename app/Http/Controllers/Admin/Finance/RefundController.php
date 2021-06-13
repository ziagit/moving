<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Earning;
use App\Http\Controllers\Controller;
use App\Order;
use App\Refund;
use App\Shipper;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refund = Refund::with('shipper')->paginate(5);
        return response()->json($refund);
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
        $order = Order::where("uniqid",$request->order)->first();
        $er=Earning::where('order_id',$order->id)->first();
        $chargeId = $order->charge_id;
        try {
            $refund = Stripe::refunds()->create($chargeId);
            $ref = new Refund();
            $ref->amount = $refund['amount']/100;
            $ref->refund_id = $refund['id'];
            $ref->earning_id = $er->id;
            $ref->shipper_id = $request->shipper_id;
            $ref->save();
            $this->updateEarning($er->id);
            return response()->json('Refunded successfully!',200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('shipper')->where("uniqid", $id)->first();
        return response()->json($order);
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
        $chargeId = $request->order_detail['charge_id'];
        try {
            $refund = Stripe::refunds()->create($chargeId);
            $ref = new Refund();
            $ref->amount = $refund['amount'];
            $ref->refund_id = $refund['id'];
            $ref->earning_id = $id;
            $ref->shipper_id = $request->order_detail['shipper_id'];
            $ref->save();
            $this->updateEarning($ref, $id);
            return response()->json('Refunded successfully!',200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function updateEarning($id){
        $earning = Earning::find($id);
        $earning->status = 'Refunded';
        $earning->update();
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
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $payouts = Order::where('uniqid', 'like', '%' . $keywords . '%')
            ->orWhereHas('shipper', function ($q) use ($keywords) {
                return $q->where('first_name', 'like', '%' . $keywords . '%');
            })
            ->with('shipper')
            ->paginate(5);
        return response()->json($payouts);
    }
}
