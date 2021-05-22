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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'billing' => 'required',
            'carrier' => 'required',
            'contacts' => 'required',
            'from' => 'required',
            'to' => 'required',
            'moving_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator);
        }
        try {
            $customerId = $this->storeCustomer($request->contacts);
            if ($customerId) {
                $order = $this->storeOrder($request, $customerId);
                $job = $this->createNewJob($order->id, $customerId, $request->carrier);

                $user  = Carrier::with('user')->find($request->carrier['id'])->user;

                //return response()->json(["message"=>"your order created!!!"]);
                $admin = User::find(1);
                $admin->notify(new JobCreated($job));

                $user->notify(new JobCreated($job));
                return response()->json($order);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function storeOrder($request, $customerId)
    {
        $floor_from = 0;
        $floor_to = 0;
        $contactId = $this->storeContact($request->contacts);
        $addressIds = $this->storeAddress($request);

        $order = Order::where('uniqid', $request->billing['id'])->first();
        if ($request->floors) {
            $floor_from = $request->floors['pickup'];
            $floor_to = $request->floors['destination'];
        }
        $moving_type = Movingtype::where('code',$request->moving_type['code'])->first()->id;
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
        $order->shipper_id = $customerId;
        $order->contact_id = $contactId;

        $order->update();
        $order->addresses()->attach($addressIds);
        
        if($request->supplies){
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
    }

    public function storeContact($request)
    {
        $contacts = [
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email']
        ];
        $id = Contact::insertGetId($contacts);
        return $id;
    }
    public function storeAddress($request)
    {
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
    }

    public function storeCustomer($data)
    {
        if (Auth::check() && auth()->user()->roles[0]->name === "customer") {
            $shipper = User::with('shipper')->find(Auth::id())->shipper;
            if ($shipper) {
                return $shipper->id;
            }
            return false;
        }
        $shipper = new Shipper();
        $shipper->first_name = $data['name'];
        $shipper->save();

        return $shipper->id;
    }

    public function createNewJob($order, $customerId, $carrier)
    {
        $job = new Job();
        $job->order_id = $order;
        $job->shipper_id = $customerId;
        $job->carrier_id = $carrier['id'];
        $job->save();
        return $job;
    }

    public function calculateDW($item)
    {
        $x = (($item['width'] * $item['height'] * $item['length']) / 166) * $item['number'];
        $y = $item['weight'] * $item['number'];
        $dw = $x >= $y ? $x : $y;
        return round($dw);
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
