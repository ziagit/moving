<?php

namespace App\Http\Controllers\Shipper;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Job;
use App\Jobstatus;
use App\Notifications\JobUpdated;
use App\Notifications\UserJobUpdated;
use App\Order;
use Illuminate\Http\Request;
use App\User;
use Exception;

class ShipperOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*   $user = User::with('shipper')->find(Auth::id())->shipper->id;
        return $user; */
        $shipper = User::with('shipper')->find(Auth::id())->shipper;
        $order = Order::with('addresses')->where('shipper_id', $shipper->id)->orderBy('id', 'DESC')->get();
        return response()->json($order);
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
        try {
            $orders = Order::with('addresses', 'items', 'contact', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->find($id);
            return response()->json($orders);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
        $order = Order::find($id);
        $order->status = $request->status;
        $order->update();
        $this->sms($request);
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return $user->notify(new JobUpdated($request));
            }
            return response()->json(['message' => 'Canceled successfully'], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function sms($request)
    {
        try {
            $nexmo = app('Nexmo\Client');
            $nexmo->message()->send([
                'to'   => $request->phone,
                'from' => '+93793778030',
                'text' => 'Dear partner this order is ' . $request->status
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
