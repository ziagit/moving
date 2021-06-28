<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Constant;
use App\Earning;
use App\Http\Services\Sms;
use App\Mail\CustomerPaid;
use App\Mail\OrderUpdated;
use App\Notifications\CustomerPaid as NotificationsCustomerPaid;
use App\Notifications\OrderUpdated as NotificationsOrderUpdated;
use App\Order;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
                $this->calculate($request, $id);
            }
            $this->createNotification($request, $order);
            return response()->json("Order updated", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function createNotification($request, $order)
    {
        try {
            $userId = $request->order_detail['shipper_contacts']['user']['id'];
            $user = User::find($userId);
            if ($user) {
                //email
                if($user->email){
                    Mail::to($user->email)->queue(new OrderUpdated($order->id));
                }
                //sms
                $sms = new Sms();
                $sms->updateOrder($user->phone, $order);
                //notify
                $user->notify(new NotificationsOrderUpdated($order));
            }
            //sms
            $this->readNotification($request->notificationId);
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
            $this->paymentNotification($request);
            return response()->json('Payment proceed successfully!', 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function paymentNotification($request)
    {
        try {
            $email = $request->order_detail['shipper_contacts']['user']['email'];
            $user = User::where('email', $email)->first();
            if ($user) {
                //email
                Mail::to($user->email)->queue(new CustomerPaid($request->order_detail));
                //sms
                $sms = new Sms();
                $sms->customerPaid($user->phone, $request->order_detail);
                //notify
                $user->notify(new NotificationsCustomerPaid($request->order_detail['uniqid']));
            }
            //sms
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
