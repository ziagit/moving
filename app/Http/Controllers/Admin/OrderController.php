<?php

namespace App\Http\Controllers\Admin;

use App\Carrier;
use App\Constant;
use App\Earning;
use App\Http\Controllers\Controller;
use App\Http\Services\Sms;
use App\Item;
use App\Job;
use App\Mail\CustomerPaid;
use App\Mail\OrderUpdated;
use App\Movingsize;
use App\Notifications\CustomerPaid as NotificationsCustomerPaid;
use App\Notifications\JobUpdated;
use App\Notifications\MoverPaid;
use App\Notifications\OrderPaid;
use App\Notifications\OrderUpdated as NotificationsOrderUpdated;
use App\Notifications\UserJobUpdated;
use App\Officesize;
use App\Order;
use App\Shipper;
use App\Supply;
use App\User;
use App\Vehicle;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('movingtype')->paginate(10);
        return response()->json($orders);
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
            $orders = Order::with('shipperContacts', 'addresses', 'items', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->find($id);
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
        try {
            if ($request->status == 'Completed') {
                $this->calculate($request, $id);
            }
            return $this->createNotification($request, $order);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function createNotification($request, $order)
    {
        try {
            $email = $request->shipper_contacts['user']['email'];
            $user = User::where('email', $email)->first();
            //email
            Mail::to($user->email)->queue(new OrderUpdated($order));
            //sms
            $sms = new Sms();
            $sms->updateJob($user->phone, $order);
            //notify
            $user->notify(new NotificationsOrderUpdated($order));
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function readNotification($id)
    {
        $notification = auth()->user()->unreadNotifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return $notification;

        /*    DB::table('notifications')->where('id',$id)->update(['read_at'=>Carbon::now()]);
        return ; */
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

    public function calculate($request, $id)
    {
        $subtotal = $request->moving_cost + $request->travel_cost;
        $serviceFee = Constant::where('code', 'servicecharge')->first()->value;
        $taxCharge = Constant::where('code', 'tax')->first()->value; //get tax 
        $subtotal = $subtotal - ($subtotal * $serviceFee / 100);
        $subtotal = $subtotal + $request->supplies_cost;
        $paidGST = $subtotal * $taxCharge / 100;
        $subtotal = $subtotal + $paidGST;
        $unPaidGST = $request->tax - $paidGST;

        $carrierEarning = $subtotal + $paidGST;
        $tingsAppEarning = $request->cost - $carrierEarning;
        $earning = new Earning();
        $earning->received_gst = $request->tax;
        $earning->paid_gst = $paidGST;
        $earning->unpaid_gst = $unPaidGST;
        $earning->tingsapp_earning = round($tingsAppEarning, 2);
        $earning->carrier_earning = round($carrierEarning, 2);
        $earning->carrier_id = $request->job_with_carrier['carrier_id'];
        $earning->job_id = $request->job_with_carrier['id'];
        $earning->order_id = $id;
        $earning->save();
        $this->processPayment($request);
        return $earning;
    }
    public function processPayment($request)
    {
        sleep(1);
        try {
            $order = Order::find($request->id);
            $charge = Stripe::charges()->create([
                'amount' => $request->cost,
                'currency' => 'USD',
                'description' => 'Moving costs',
                'customer' => $request->shipper_contacts['stripe_customer_id']
            ]);
            $order->charge_id = $charge['id'];
            $order->update();
            $this->paymentNotification($request);
            return response()->json('Payment proceed successfully!', 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function paymentNotification($request)
    {
        try {
            $email = $request->shipper_contacts['user']['email'];
            $user = User::where('email', $email)->first();
            //email
            Mail::to($user->email)->queue(new CustomerPaid($request));
            //sms
            $sms = new Sms();
            $sms->customerPaid($user->phone, $request->uniqid);
            //notify
            $user->notify(new NotificationsCustomerPaid($request->uniqid));
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $job = Order::where('uniqid', 'like', '%' . $keywords . '%')
            ->with('movingtype')
            ->paginate(5);
        return $job;
    }
}
