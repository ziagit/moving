<?php

namespace App\Http\Controllers\Carrier;

use App\Carrier;
use App\Http\Controllers\Controller;
use App\Job;
use App\Jobstatus;
use App\Notifications\JobUpdated;
use App\Notifications\UserJobUpdated;
use App\User;
use App\CarrierEarning;
use App\Constant;
use App\Earning;
use App\Item;
use App\Movingsize;
use App\Notifications\CustomerPaid;
use App\Notifications\OrderUpdated;
use App\Officesize;
use App\Order;
use App\Rate;
use App\Shipper;
use App\Supply;
use App\Vehicle;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $jobs = Job::with('orderDetail')->where('carrier_id', $carrierId)->orderBy('id', 'DESC')->paginate(5);
        return response()->json($jobs);
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
        $job = Job::with('orderDetail')->find($id);
        return response()->json($job);
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
        $order = Order::find($request->order_detail['id']);
        $order->status = $request->status;
        $order->update();
        try {
            if ($request->status == 'Completed') {
                return $this->calculate($request, $id);
                $this->readNotification($request->notificationId);
            }
            $this->sms($request);
            $customerEmail = $request->order_detail['shipper_contacts']['user']['email'];
            $user = User::where('email', $customerEmail)->first();
            if ($user) {
                return $user->notify(new OrderUpdated($order));
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function sms($request)
    {
        $customerPhone = $request->order_detail['shipper_contacts']['user']['phone'];
        try {
            $nexmo = app('Nexmo\Client');
            $nexmo->message()->send([
                'to'   => $customerPhone,
                'from' => '+93793778030',
                'text' => 'Dear Customer this order is being' . $request->status
            ]);
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
        $subtotal = $request->order_detail['moving_cost'] + $request->order_detail['travel_cost'];
        $serviceFee = Constant::where('code', 'servicecharge')->first()->value;
        $taxCharge = Constant::where('code', 'tax')->first()->value; //get tax 
        $subtotal = $subtotal - ($subtotal * $serviceFee / 100);
        $subtotal = $subtotal + $request->order_detail['supplies_cost'];
        $paidGST = $subtotal * $taxCharge / 100;
        $subtotal = $subtotal + $paidGST;
        $unPaidGST = $request->order_detail['tax'] - $paidGST;
        $carrierEarning = $subtotal + $paidGST;
        $tingsAppEarning = $request->order_detail['cost'] - $carrierEarning;
        $earning = new Earning();
        $earning->received_gst = $request->order_detail['tax'];
        $earning->paid_gst = $paidGST;
        $earning->unpaid_gst = $unPaidGST;
        $earning->tingsapp_earning = round($tingsAppEarning, 2);
        $earning->carrier_earning = round($carrierEarning, 2);
        $earning->carrier_id = $request->carrier_id;
        $earning->job_id = $request->id;
        $earning->order_id = $request->order_detail['id'];
        $earning->save();
        $this->processPayment($request);
        return $earning;
    }
    public function processPayment($request)
    {
        sleep(1);
        try {
            $order = Order::find($request->order_detail['id']);
            $charge = Stripe::charges()->create([
                'amount' => $request->order_detail['cost'],
                'currency' => 'USD',
                'description' => 'Moving costs',
                'customer' => $request->order_detail['shipper_contacts']['stripe_customer_id']
            ]);
            $order->charge_id = $charge['id'];
            $order->update();
            $this->customerPaid($request);
            return response()->json('Payment proceed successfully!', 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function customerPaid($request)
    {
        try {
            $shipperMail = $request->order_detail['shipper_contacts']['user']['email'];
            $shipper = User::where('email', $shipperMail)->first();
            if ($shipper) {
                $shipper->notify(new CustomerPaid($request->order_detail['id']));
            }
            $nexmo = app('Nexmo\Client');
            $nexmo->message()->send([
                'to'   => $request->order_detail['shipper_contacts']['user']['phone'],
                'from' => '+93793778030',
                'text' => 'Dear Customer your payment proceed to TingsApp'
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $job = Job::where('id', 'like', '%' . $keywords . '%')
            ->orWhereHas('order', function ($q) use ($keywords) {
                return $q->where('uniqid', 'like', '%' . $keywords . '%');
            })
            ->with('orderDetail')
            ->paginate(3);
        return $job;
    }
}
