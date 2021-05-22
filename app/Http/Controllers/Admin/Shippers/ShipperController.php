<?php

namespace App\Http\Controllers\Admin\Shippers;

use App\Address;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Shipper;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippers = Shipper::with('address','contact')->paginate(10);
        return response()->json($shippers);
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
        $shipper = Shipper::find($id);
        $shipper->first_name = $request->first_name;
        $shipper->last_name = $request->last_name;
        $shipper->update();
        $this->updateContact($request);
        $this->updateAddress($request);
        return response()->json(["message"=>"Updated successfully!"],200);
    }
    public function updateContact($request){
        $contact = Contact::find($request->contactId);
        $contact->name = $request->last_name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->update();
        return $contact->id;
    }
    public function updateAddress($request){
        $address = Address::find($request->addressId);
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->address;
        $address->update();
        return $address->id;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
          
    public function destroy($id)
    {
        if ($shipper = Shipper::find($id)) {
            $shipper->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $shipper = Shipper::where('first_name', 'like', '%' . $keywords . '%')
        ->with('address','contact')
            ->paginate(10);
        return $shipper;
    }
}
