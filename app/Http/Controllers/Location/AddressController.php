<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;
use App\City;
use App\State;
use App\Country;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Address::all();
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
        $address = Address::find($id);
        return $address;
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

    public function countriesFull(){
        $countries = Country::with('statesAndCities')->get();
        return response()->json($countries);
    }
    public function countries(){
        $countries = Country::all();
        return response()->json($countries);
    }
    public function states(){
        $states = State::all();
        return response()->json($states);
    }
    public function statesCities(){
        $states = State::with('cities')->get();
        return response()->json($states);
    }
    public function cities(){
        $cities = City::all();
        return response()->json($cities);
    }
    public function searchState(Request $request, $country)
    {
        $keywords = $request->keywords;
        $results = State::where('name', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }
    public function searchCity(Request $request, $state)
    {
        $keywords = $request->keywords;
        $results = City::where('state_id', $state)
        ->where('name', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }
    public function searchZip(Request $request, $city)
    {
        $keywords = $request->keywords;
        $results = Address::where('city', $city)
        ->where('zip', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }
    public function searchAddress(Request $request, $zip)
    {
        $keywords = $request->keywords;
        $results = Address::where('zip', $zip)
        ->where('address', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }
    public function searchStateCity(Request $request, $country)
    {
        $keywords = $request->keywords;
        $results = Address::where('country_id', $country)
        ->where('state', 'like', '%' . $keywords . '%')
        ->orWhere('city', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }
    public function searchZipAddress(Request $request, $city)
    {
        $keywords = $request->keywords;
        $results = Address::where('city', $city)
        ->where('zip', 'like', '%' . $keywords . '%')
        ->orWhere('address', 'like', '%' . $keywords . '%')
        ->paginate(5);
        return $results;
    }

}
