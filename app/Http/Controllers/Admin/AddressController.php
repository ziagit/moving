<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::with('shipper','carrier','orders')->paginate(10);
        return response()->json($addresses);
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
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required'
        ]);
        $address = new Address();

        $address->name = $request->name;
        $address->city_id = $request->city;

        $address->save();
        return response()->json(["message" => "Saved Successfully."], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);
        return response()->json($address);
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
        $this->validate($request, [
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
        ]);
        $address = Address::find($id);

        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->address;
        $address->country = $request->country;

        $address->update();
        return response()->json(["message" => "Updated Successfully."], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::find($id);
        $address->delete();
        return response()->json(["message"=>"Deleted successfully!"],200);
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $res = Address::where('zip', 'like', '%' . $keywords . '%')
            ->orWhere('city', 'like','%' . $keywords . '%')
            ->with('shipper','carrier','orders')
            ->paginate(5);
        return $res;
/*         $city = Address::where('name', 'like', '%' . $keywords . '%')
            ->orWhereHas('city', function ($q) use ($keywords) {
                return $q->where('name', 'like', '%' . $keywords . '%');
            })
            ->with('city')
            ->paginate(10);
        return $city; */
    }
}
