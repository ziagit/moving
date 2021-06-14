<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Shipper;
use App\Item;
use App\Order;
use App\Carrier;
use App\Job;
use App\Notifications\JobCreated;
use App\Address;
use App\Contact;
use App\Movernumber;
use App\Movingsize;
use App\Movingtype;
use App\Officesize;
use App\Supply;
use App\User;
use App\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $order = $this->createOrder($request);
            $job = $this->createNewJob($order->id, $request);
            $this->createNotification($job,  $order, $request);
            return response()->json($order);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function createOrder($request)
    {
        try {
            $floor_from = 0;
            $floor_to = 0;
            $addressIds = $this->storeAddress($request);
            $shipperId = $this->shipper();
            if ($request->floors) {
                $floor_from = $request->floors['pickup'];
                $floor_to = $request->floors['destination'];
            }

            $moving_type = Movingtype::where('code', $request->moving_type['code'])->first()->id;
            $moving_size = $request->moving_type['code'] == 'apartment' ? Movingsize::where('code', $request->moving_size['code'])->first()->id : null;
            $office_size = $request->moving_type['code'] == 'office' ? Officesize::where('code', $request->moving_size['code'])->first()->id : null;

            $number_of_movers = $request->number_of_movers ?  Movernumber::where('code', $request->number_of_movers['code'])->first()->id : null;
            $vehicle = $request->vehicle ? Vehicle::where('code', $request->vehicle['code'])->first()->id : null;
            
            $order = new Order();

            $order->uniqid = 'O' . rand();

            $order->pickup_date = $request->moving_date['date'];
            $order->appointment_time = $request->moving_date['time'];
            $order->instructions = $request->instructions;

            $order->movingtype_id = $moving_type;
            $order->floor_from = $floor_from;
            $order->floor_to = $floor_to;
            $order->movingsize_id = $moving_size;
            $order->officesize_id = $office_size;
            $order->movernumber_id = $number_of_movers;
            $order->vehicle_id = $vehicle;

            $order->cost = $request->carrier['price'];
            $order->travel_cost = $request->carrier['travel'];
            $order->moving_cost = $request->carrier['moving'];
            $order->service_fee = $request->carrier['service_fee'];
            $order->disposal_fee = $request->carrier['disposal_fee'];
            $order->supplies_cost = $request->carrier['supplies_cost'];

            $order->distance = $request->distance;
            $order->duration = $request->duration;
            $order->tax = $request->carrier['tax'];
            $order->shipper_id = $shipperId;
            $order->save();

            $order->addresses()->attach($addressIds);
            if ($request->supplies) {
                foreach ($request->supplies as $supply) {
                    if (!empty($supply)) {
                        $sup = Supply::where('code', $supply['code'])->first();
                        $order->supplies()->attach($sup->id, ['number' => $supply['number']]);
                    }
                }
            }
            if ($request->items) {
                foreach ($request->items as $item) {
                    if (!empty($item)) {
                        $itm = Item::where('code', $item['code'])->first();
                        $order->items()->attach($itm->id, ['number' => $item['number']]);
                    }
                }
            }
            return $order;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function shipper(){
        $shipper = Shipper::where('user_id',Auth::id())->first();
        return $shipper->id;
    }
    public function storeAddress($request)
    {
        try {
            $addressIds = array();
            $fromAddress = [
                'street' => $request->from['street'],
                'street_number' => $request->from['street_number'],
                'zip' => $request->from['zip'],
                'city' => $request->from['city'],
                'state' => $request->from['state'],
                'formatted_address' => $request->from['formatted_address'],
                'country' => $request->from['country']
            ];
            $fromId = Address::insertGetId($fromAddress);
            array_push($addressIds, $fromId);
            $toAddress = [
                'street' => $request->to['street'],
                'street_number' => $request->to['street_number'],
                'zip' => $request->to['zip'],
                'city' => $request->to['city'],
                'state' => $request->to['state'],
                'formatted_address' => $request->to['formatted_address'],
                'country' => $request->to['country']
            ];
            $toId = Address::insertGetId($toAddress);
            array_push($addressIds, $toId);
            return $addressIds;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function createNewJob($order, $request)
    {
        
        try {
            $job = new Job();
            $job->order_id = $order;
            $job->shipper_id = $this->shipper();
            $job->carrier_id = $request->carrier['id'];
            $job->save();
            return $job;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function createNotification($job,  $order, $request)
    {
        try {
            $user  = Carrier::with('user')->find($request->carrier['id'])->user;
            $user->notify(new JobCreated($job));
            $admin = User::find(1);
            $admin->notify(new JobCreated($job));
            return true;
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
        $job = Job::with('orderDetail', 'jobstatus')->find($id);
        return $job;
    }
    public function carrierContacts($id)
    {
        $carrier = Carrier::with('contact')->find($id);
        return $carrier;
    }
}
