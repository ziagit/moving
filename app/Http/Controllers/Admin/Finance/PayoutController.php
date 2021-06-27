<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Carrier;
use App\Earning;
use App\Http\Controllers\Controller;
use App\Http\Services\Sms;
use App\Mail\MoverPaid;
use App\Notifications\CarrierPaid;
use App\Notifications\MoverPaid as NotificationsMoverPaid;
use App\Payout;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payouts = Payout::with('earnings', 'carrier')->paginate(5);
        return response()->json($payouts);
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
        $payout = new Payout();
        $payout->from = $request->from;
        $payout->to = $request->to;
        $payout->amount = $request->amount;
        $payout->carrier_id = $request->carrier;
        $payout->save();
        $this->updateEarning($payout, $request->earning_ids);
        $this->createNotification($request->carrier,$request->amount);
        return response()->json('Payment succeed!', 200);
    }
    public function updateEarning($payout, $ids)
    {
        foreach ($ids as $id) {
            $earning = Earning::find($id);
            $earning->status = 'Paid';
            $earning->update();
            $earning->payouts()->attach($payout->id);
        }
        return true;
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
        try {
            $earning = Earning::find($id);
            $earning->status = $request->status;
            $earning->update();
            $this->payNow($request, $earning);
            return response()->json("Paid successfully!", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function payNow($request, $earning)
    {
        $today = date('d-m-y h:i:s');
        try {
            $payout = new Payout();
            $payout->amount = round($earning->carrier_earning + $earning->paid_gst, 2);
            $payout->from = $today;
            $payout->to = $today;
            $payout->carrier_id = $request->order_detail['job_with_carrier']['carrier_id'];
            $payout->save();
            $earning->payouts()->attach($payout->id);
            $this->createNotification($request->order_detail['job_with_carrier']['carrier_detail']['id'], $payout->amount);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function createNotification($carrierId, $amount)
    {
        $carrier = Carrier::find($carrierId)->first();
        $user = User::find($carrier->user_id);
        try {
            //email
            return "hi";
            Mail::to($user->email)->queue(new MoverPaid($amount));
            //sms
            $sms = new Sms();
            $sms->moverPaid($user->phone, $amount);
            //notify
            $user->notify(new NotificationsMoverPaid($amount));
            return true;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
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
    public function search(Request $request)
    {
        return "hi";
        $keywords = $request->keywords;
        $payouts = Payout::where('id', 'like', '%' . $keywords . '%')
            ->orWhereHas('carrier', function ($q) use ($keywords) {
                return $q->where('first_name', 'like', '%' . $keywords . '%');
            })
            ->with('carrier')
            ->paginate(5);
        return response()->json($payouts);
    }

    public function carriers()
    {
        $carriers = Carrier::all();
        return response()->json($carriers);
    }
    public function earnings($id)
    {
        $earnings = Earning::where('carrier_id', $id)
            ->where('status', 'Unpaid')
            ->get();
        return response()->json($earnings);
    }
}
