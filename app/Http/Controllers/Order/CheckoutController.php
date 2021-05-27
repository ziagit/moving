<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checkout');
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
        // return response()->json($request);
        if (Auth::check() && Auth::user()->roles[0]->name === 'customer') {
            return $orderId = $this->createEmptyOrder($request);
            if ($this->checkCustomer() === null) {
                try {
                    $customer = Stripe::customers()->create([
                        'source' => $request->stripeToken,
                        'email' => $request->email,
                        'name' => $request->name_oncard,
                        'description' => "Payment for moving",
                    ]);
                    $this->updateUser($customer['id']);
                    return [
                        'message' => 'Thank you! your card added successfully.',
                        'id' => $orderId,
                        'status' => false,
                        'email' => $request->email
                    ];
                } catch (Exception $e) {
                    return response()->json(['message' => $e], 500);
                }
            } else {
                $customerId = $this->checkCustomer();
                $customer = Stripe::customers()->update($customerId, [
                    'source' => $request->stripeToken,
                    'email' => $request->email,
                    'name' => $request->name_oncard,
                    'description' => "Moving payment",
                ]);
                return response()->json(
                    [
                        'message' => 'Thank you! your card updated successfully.',
                        'id' => $orderId,
                        'status' => false,
                        'email' => $request->email
                    ]
                );
            }
        }
        return null;
    }

    public function chargeCustomer(Request $request)
    {
        if (!$request->id) {
            $user = Auth::user();
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $request->price,
                    'currency' => 'USD',
                    'description' => 'Shipment costs',
                    'customer' => $user->customer_id
                ]);
                $orderId = $this->createEmptyOrder($charge['id']);
                return response()->json(
                    [
                        'message' => 'Thank you! your payment was successful.',
                        'id' => $orderId,
                        'status' => true,
                        'email' => $request->email
                    ]
                );
            } catch (CardErrorException $e) {
                return $e;
            }
        } else {
            $order = Order::where('uniqid', $request->id)->first();
            if (Stripe::charges()->find($order->charge_id)) {
                return response()->json(
                    [
                        'message' => 'You already paid for this order!',
                        'id' => $request->id,
                        'status' => true,
                        'email' => $request->email
                    ]
                );
            }
        }
    }
    public function charge($request)
    {
        if (!$request->orderId) {
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $request->price,
                    'currency' => 'USD',
                    'source' => $request->stripeToken,
                    'description' => 'Shipment costs',
                    'receipt_email' => $request->email,
                ]);
                $orderId = $this->createEmptyOrder($charge['id']);
                return response()->json(
                    [
                        'message' => 'Thank you! your payment was successful.',
                        'id' => $orderId,
                        'status' => true,
                        'email' => $request->email
                    ]
                );
            } catch (CardErrorException $e) {
                return $e;
            }
        } else {
            $order = Order::where('uniqid', $request->orderId)->first();
            if (Stripe::charges()->find($order->charge_id)) {
                return response()->json(
                    [
                        'message' => 'You already paid for this order!',
                        'id' => $request->orderId,
                        'status' => true,
                        'email' => $request->email
                    ]
                );
            }
        }
    }
    public function checkCustomer()
    {
        $customerId = Auth::user()->customer_id;
        if ($customerId) {
            $customer = Stripe::customers()->find($customerId);
            return $customer['id'];
        } else {
            return null;
        }
    }

    public function updateUser($customerId)
    {
        $user = Auth::user()->id;
        $user = User::find($user);
        $user->customer_id = $customerId;
        $user->update();
        return true;
    }
    public function createEmptyOrder($request)
    {
        return $request;
        $order = new Order();
        $order->cost = $request->cost;
        $order->charge_id = "charge id is this required?";
        $order->uniqid = 'TAO' . date('Ymd') . rand();
        $order->save();
        return $order->uniqid;
    }
    public function checkPayment($id)
    {
        $order = Order::where('uniqid', $id)->first();
        if ($order) {
            if (Stripe::charges()->find($order->charge_id)) {
                return response()->json(
                    ['message' => 'Thanks! your payment was successfull.', 'status' => true]
                );
            }
            return response()->json(
                ['message' => 'Charge id not muching', 'status' => false]
            );
        }
        return response()->json(
            ['message' => 'Order not found', 'status' => false]
        );
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
