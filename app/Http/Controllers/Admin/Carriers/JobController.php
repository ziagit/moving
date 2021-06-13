<?php

namespace App\Http\Controllers\Admin\Carriers;

use App\CarrierEarning;
use App\Constant;
use App\Earning;
use App\Http\Controllers\Controller;
use App\Job;
use App\Jobstatus;
use App\Notifications\JobUpdated;
use App\Notifications\UserJobUpdated;
use App\Rate;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::with('orderDetail','carrier')->orderBy('id', 'DESC')->paginate();
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
        $job = Job::with('orderDetail','carrierDetail')->find($id);
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

        $job = Job::find($id);
        $job->jobstatus_id = $request->status;
        $job->update();
        if ($request->status == 5) {
           return $this->calculate($request, $id);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return $this->notifyUser($user, $id);
        }
        return $this->notifyShipper($request->email, $id);
    }

    public function notifyUser($user, $id)
    {
        $job = Job::with('orderDetail')->find($id);

        $user->notify(new JobUpdated($job));
        return $job;
    }

    public function notifyShipper($email, $id)
    {
        $job = Job::with('orderDetail')->find($id);
        Notification::route('mail', $email)
            ->notify(new JobUpdated($job));
        return $job;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function calculate($request, $id)
    {
        $base_fare = $this->baseFare($request);
        return $base_fare;
        $distancePrice = Constant::where('code', 'distance')->first()->value; //get distance charge
        $distanceCharge = $request->distance * $distancePrice; //distance/km google gave us, 

        $tax = Constant::where('code', 'tax')->first()->value; //get tax 
        $taxCharge = $request->cost * $tax / 100;//calculate tax

        $suppliesCharge = $this->suppliesCost($request); //get supplies cost

        $service = Constant::where('code', 'servicecharge')->first()->value; //get service charge
        $costWithoutTax = $request->cost - $taxCharge;
        $serviceCharge = $costWithoutTax * $service /100;
        $floorTime = Constant::where('code', 'floortime')->first()->value; //get service charge

        $hoursToMove = $request->moving_size['hours_to_move']; //get the time that 2 mover + truck 
        $stairTime = ($request->from_floor + $request->to_floor) * $floorTime / 60; //each floor 30 min, convert to hr
        $carrierRate = Rate::where('vehicle_id', $request->vehicle['id'])->where('carrier_id', $request->carrier_id)->first();

        $movingCharge = ($hoursToMove + $stairTime + $request->duration) * $carrierRate->price;

        $this->createEarning($request, $id,  $distanceCharge, $movingCharge, $suppliesCharge, $serviceCharge, $taxCharge);
        return $carrierRate->price;
    }

    public function createEarning($request, $id, $distanceCharge, $movingCharge, $suppliesCharge, $serviceCharge, $tax)
    {
        $earning = new Earning();
        $earning->job_id = $id;
        $earning->order_id = $request->order;
        $earning->carrier_id = $request->carrier_id;
        $earning->distance_charge = $distanceCharge;
        $earning->moving_charge = $movingCharge;
        $earning->supplies_charge = $suppliesCharge;
        $earning->service_charge = $serviceCharge;
        $earning->tax = $tax;
        $earning->save();
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
        return $vehicles->where('code','minivan')->first()->base_fare;
    }

    public function suppliesCost($request)
    {
        $total = 0;
        if ($request->supplies) {
            foreach ($request->supplies as $supply) {
                $total = $total + ($supply['price'] * $supply['number']);
            }
        }
        return $total;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $range = Job::find($id);
        $range->delete();
        return response()->json(['message'=>'Deleted successfully!'],200);
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $citycodes = Job::where('id', 'like', '%' . $keywords . '%')
            ->orWhereHas('carrier', function ($q) use ($keywords) {
                return $q->where('first_name', 'like', '%' . $keywords . '%');
            })
            ->with('carrier','orderDetail','jobstatus')
            ->paginate(10);
        return $citycodes;
    }

    public function jobStatus()
    {
        return Jobstatus::where('id', '<>', 6)->get();
    }
}
