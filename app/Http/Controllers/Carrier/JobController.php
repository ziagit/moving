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
use App\Officesize;
use App\Order;
use App\Rate;
use App\Supply;
use App\Vehicle;
use Carbon\Carbon;
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
        $jobs = Job::with('orderDetail')->where('carrier_id', $carrierId)->orderBy('id', 'DESC')->get();
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
        $id = Job::find($id)->order_id;
        $order = Order::find($id);
        $order->status = $request->status;
        $order->update();
        try {
            if ($request->status == 'Completed') {
              return  $this->calculate($request, $id);
                $this->readNotification($request->notificationId);
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return $this->notifyUser($user, $id);
            }
            return $this->notifyShipper($request->email, $id);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function notifyUser($user, $id)
    {
        $job = Job::with('orderDetail')->find($id);

        $user->notify(new UserJobUpdated($job));
        return $job;
    }

    public function notifyShipper($email, $id)
    {
        $job = Job::with('orderDetail')->find($id);
        Notification::route('mail', $email)
            ->notify(new JobUpdated($job));
        return $job;
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
        $baseFare = $this->baseFare($request); //get the truck fair
        $distancePrice = Constant::where('code', 'distance')->first()->value; //get distance charge
        $taxCharge = Constant::where('code', 'tax')->first()->value; //get tax 
        $service = Constant::where('code', 'servicecharge')->first()->value; //get service charge
        $distanceCharge = $request->distance * $distancePrice; //distance/km google gave us, 
        $hoursToMove = $this->hoursToMove($request); //get the time that 2 mover + truck 
        $stairTime = $this->stairTime($request); // get the time if stair used
        $disposalFee = $this->disposalFee($request);

        $suppliesCost = $this->suppliesCost($request); //get supplies cost

        $carrier = Carrier::with('rate')->find($request->carrier_id);
        //find travel cost
        $travelCost = ($baseFare + $distanceCharge + ($carrier->rate['price'] / 60) * $request->duration); // by 60, is because duration is in minut not hour
        //return $request->number_of_movers['number'];
        if ($request->moving_type['code'] == 'few_items' || $request->moving_type['code'] == 'junk_removal') {
            //few items case
            $movingCost = ($hoursToMove + $stairTime) * $carrier->rate['price'];
        } else {
            if ($request->number_of_movers['code'] == '1mover') {
                // 1 mover case
                $movingCost = ($hoursToMove + 1 + $stairTime) * (($carrier->rate['price'] * 67) / 100);
            } else if ($request->number_of_movers['code'] == '3movers') {
                // 3 movers case
                $movingCost = ($hoursToMove - 1 + $stairTime) * (($carrier->rate['price'] * 133) / 100);
            } else {
                // standard case
                $movingCost = ($hoursToMove + $stairTime) * $carrier->rate['price'];
            }
        }
        $subtotal = $travelCost + $movingCost;
        //find the tax customer paid
        $receivedGST = $request->cost - ($subtotal + ($subtotal) * $service / 100 + $suppliesCost);
        //TingsApp earning
        $serviceFee = ($subtotal) * $service / 100;
        $subtotal = $subtotal - $serviceFee;
        $subtotal = $subtotal + $suppliesCost;
        //tax that 
        $paidGST = $subtotal * $taxCharge / 100;
        $carrierEarning = $subtotal + $paidGST;
        $unPaidGST = $receivedGST - $paidGST;
        $tingsAppEarning = $request->cost - $carrierEarning;
        $earning = new Earning();
        $earning->travel_cost = round($travelCost, 2);
        $earning->moving_cost = round($movingCost, 2);
        $earning->supplies_cost = round($suppliesCost, 2);
        $earning->service_fee = round($serviceFee, 2);
        $earning->disposal_fee = round($disposalFee,2);
        $earning->tingsapp_earning = round($tingsAppEarning, 2);
        $earning->received_gst = round($receivedGST, 2);
        $earning->paid_gst = round($paidGST, 2);
        $earning->unpaid_gst = round($unPaidGST, 2);
        $earning->carrier_earning = round($carrierEarning, 2);
        $earning->carrier_id = $request->carrier_id;
        $earning->job_id = $id;
        $earning->order_id = $request->order_id;
        $earning->save();
        return $earning;
    }

    public function baseFare($request)
    {
        $vehicles = Vehicle::all();
        if ($request->vehicle) {
            $requestedVehicle = $request->vehicle['code'];
            foreach ($vehicles as $vehicle) {
                if ($requestedVehicle == $vehicle->code) {
                    return $vehicle->base_fare;
                }
            }
            return 0;
        }
        return $vehicles->where('code', 'minivan')->first()->base_fare;
    }
    public function hoursToMove($request)
    {
        if ($request->moving_type['code'] == 'office') {
            $sizes = Officesize::get(['code', 'hours_to_move']);
            foreach ($sizes as $size) {
                if ($size->code == $request->moving_size['code']) {
                    return $size->hours_to_move;
                }
            }
        } else if ($request->moving_type['code'] == 'apartment') {
            $sizes = Movingsize::get(['code', 'hours_to_move']);
            foreach ($sizes as $size) {
                if ($size->code == $request->moving_size['code']) {
                    return $size->hours_to_move;
                }
            }
        } else {
            $times = 0;
            foreach ($request->items as $itm) {
                $item = Item::where('code', $itm['code'])->first();
                $times = $times + $itm['pivot']['number'] * $item->moving_cost;
            }
            return $times / 60;
        }
    }
    public function stairTime($request)
    {
        $floorTime = Constant::where('code', 'floortime')->first()->value; //get time that each floor takes
        $floor = $request->floor_from + $request->floor_to;
        return ($floor * $floorTime) / 60;
    }
    public function disposalFee($request)
    {
        $fees = 0;
        if ($request->moving_type['code'] == "junk_removal") {
            foreach ($request->items as $item) {
                $fee = Item::where('code', $item['code'])->first()->disposal_fee;
                $fee = $fee * $item['pivot']['number'];
                $fees = $fees + $fee;
            }
            return $fees;
        }
        return 0;
    }
    public function suppliesCost($request)
    {
        $total = 0;
        if ($request->supplies) {
            foreach ($request->supplies as $supply) {
                $sp = Supply::where('code', $supply['code'])->first();
                $total = $total + ($sp->price * $supply['pivot']['number']);
            }
        }
        return $total;
    }
}
