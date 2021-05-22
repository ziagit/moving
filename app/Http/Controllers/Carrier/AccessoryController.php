<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use App\Accessory;
use App\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $carrierId = Carrier::where('user_id', $userId)->first('id')->id;
        return Carrier::with('accessories')->find($carrierId);
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
        $accessory = Accessory::find($request->name);
        $carrier = Carrier::find($request->carrierId);

        if ($carrier->accessories->contains($accessory)) {
            return response()->json(['message' => 'Duplicate entry!'], 409);
        } else {
            $carrier->accessories()->attach($accessory, ['src_value' => $request->srcValue, 'des_value' => $request->desValue]);
            return response()->json(['message' => 'Saved successfully!'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function show($accessoryId)
    {
        $userId = Auth::user()->id;
        $carrierId = Carrier::where('user_id', $userId)->first('id')->id;

        $accessory = Carrier::find($carrierId)->accessories()->find($accessoryId);
        return response()->json($accessory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\accessory  $accessory
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
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accessoryId)
    {
        $carrier = Carrier::find($request->carrierId);
        $accessory = Accessory::find($accessoryId);

        $newAccessory = Accessory::find($request->name);

        $carrier->accessories()->detach($accessory);
        $carrier->accessories()->attach($newAccessory, ['src_value' => $request->srcValue, 'des_value' => $request->desValue]);
        return response()->json(['message' => 'Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function destroy($accessoryId)
    {
        $userId = Auth::user()->id;
        $carrierId = Carrier::where('user_id', $userId)->first('id')->id;

        $accessory = Accessory::find($accessoryId);
        $carrier = Carrier::find($carrierId);
        $carrier->accessories()->detach($accessory);
        return response()->json(['message' => 'Deleted successfully!'], 202);
    }

    public function accessories()
    {
        return Accessory::all();
    }
}
