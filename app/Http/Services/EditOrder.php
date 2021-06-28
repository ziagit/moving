<?php

namespace App\Http\Services;

use App\Shipper;
use App\Item;
use App\Order;
use App\Carrier;
use App\Job;
use App\Address;
use App\Http\Services\Sms;
use App\Mail\JobCanceled;
use App\Mail\JobChanged;
use App\Mail\JobCreated;
use App\Movernumber;
use App\Movingsize;
use App\Movingtype;
use App\Notifications\JobCanceled as NotificationsJobCanceled;
use App\Notifications\JobChanged as NotificationsJobChanged;
use App\Notifications\JobCreated as NotificationsJobCreated;
use App\Officesize;
use App\Supply;
use App\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EditOrder
{
    public function update(Request $request)
    {
        try {
            $order = $this->updateOrder($request);
            $job = $this->updateJob($order->id, $request);
            $this->createNotification($job,  $order, $request);
            return response()->json($order);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function updateOrder($request)
    {
        try {
            $floor_from = 0;
            $floor_to = 0;
            $order = Order::find($request->editable_id);
            $order->addresses()->detach();
            $order->supplies()->detach();
            $order->items()->detach();

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
            $order->status = 'Updated';
            $order->shipper_id = $shipperId;
            $order->update();

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
    public function shipper()
    {
        $shipper = Shipper::where('user_id', Auth::id())->first();
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
    public function updateJob($order, $request)
    {
        try {
            if ($request->carrier['id'] != $request->old_carrier) {
                $job = new Job();
                $job->shipper_id = $this->shipper();
                $job->carrier_id = $request->carrier['id'];
                $job->save();
                return $job;
            }
            $job = Job::where('order_id',$request->editable_id)->first();
            return $job;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function createNotification($job,  $order, $request)
    {
        $newUser  = Carrier::with('user')->find($request->carrier['id'])->user;
        $oldUser  = Carrier::with('user')->find($request->old_carrier)->user;
        $sms = new Sms();

        try {
            if($newUser->id == $oldUser->id){
                //notify the mover for job update
                Mail::to($oldUser->email)->queue(new JobChanged($order->uniqid));
                $sms->jobChanged($oldUser->phone, $job->id);
                $oldUser->notify(new NotificationsJobChanged($job));
            }else{
                //notify the old mover that job is canceled
                Mail::to($oldUser->email)->queue(new JobCanceled($job->id));
                $sms->jobCanceled($oldUser->phone, $order->uniqid);
                $newUser->notify(new NotificationsJobCanceled($job));
                //notify new mover a job is created
                Mail::to($newUser->email)->queue(new JobCreated($job->id));
                $sms->newJob($newUser->phone, $order->uniqid);
                $newUser->notify(new NotificationsJobCreated($job));
            }
            return true;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
   
}
