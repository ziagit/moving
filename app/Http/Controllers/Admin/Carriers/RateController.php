<?php

namespace App\Http\Controllers\Admin\Carriers;

use App\Http\Controllers\Controller;
use App\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = Rate::with('carrier')->paginate(10);
        return response()->json($rates);
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
            'price' => 'required',
            'carrier_id'=>'required'
        ]);
        $rate = new Rate();

        $rate->price = $request->value;
        $rate->carrier_id = $request->carrier_id;

        $rate->save();
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
        $this->validate($request, [
            'price' => 'required',
        ]);
        $rate = Rate::find($id);
        $rate->price = $request->price;
        $rate->update();
        return response()->json(["message" => "Updated successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $range = Rate::find($id);
        $range->delete();
        return response()->json(['message'=>'Deleted successfully!'],200);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $city = Rate::where('price', 'like', '%' . $keywords . '%')
            ->orWhereHas('carrier', function ($q) use ($keywords) {
                return $q->where('company', 'like', '%' . $keywords . '%');
            })
            ->with('carrier')
            ->paginate(10);
        return $city;
    }
}
