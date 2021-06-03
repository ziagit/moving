<?php

namespace App\Http\Controllers\Shipper;

use App\Address;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Shipper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class ShipperDetailsController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = JWTAuth::user()->id;
        $carrier = Shipper::with('address')->where('user_id', $userId)->first();
        return response()->json($carrier);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'formatted_address' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userId = $this->updateUser($request);
        $addressId = $this->storeAddress($request);
        $shipper = new Shipper();
        $shipper->first_name = $request->first_name;
        $shipper->last_name = $request->last_name;
        $shipper->address_id = $addressId;
        $shipper->user_id = $userId;
        $shipper->save();
        return response()->json(["message" => "Saved successfully!"], 200);
    }

    public function updateUser($request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->email != 'null') {
            $user->email = $request->email;
            $user->update();
        } else {
            $user->phone = $request->phone;
            $user->update();
        }
        return $user->id;
    }
    public function storeAddress($request){
        $address = new Address();
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->formatted_address;
        $address->save();
        return $address->id;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carrier = Shipper::with('address','contact')->find($id);
        return $carrier;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'formatted_address' => 'required',
        ]);
        $contactId = $this->updateContact($request);
        $addressId = $this->updateAddress($request);
        $shipper = Shipper::find($id);

        $shipper->first_name = $request->first_name;
        $shipper->last_name = $request->last_name;
        $shipper->address_id = $addressId;
        $shipper->contact_id = $contactId;
        $shipper->user_id = JWTAuth::user()->id;
        $shipper->update();
        return response()->json(["message" => "Updated successfully!"], 200);
    }

    public function updateContact($request){
        $user = JWTAuth::user();
        $contact = Contact::find($request->contactId);
        $contact->name = $request->last_name;
        $contact->email = $request->email;
        $contact->phone = $user->phone;
        $contact->update();
        $user->email = $request->email;
        $user->update();
        return $contact->id;
    }
    public function updateAddress($request){
        $address = Address::find($request->addressId);
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->formatted_address;
        $address->update();
        return $address->id;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function destroy(shipper $shipper)
    {
        // 
    }

}
