<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use App\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplys = Supply::all();
        return response()->json($supplys);
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
        $supply = new Supply();
        $supply->name = $request->name;
        $supply->code = $request->code;
        $supply->price = $request->price;
        $supply->save();
        return response()->json(["message"=>"Saved successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supply = Supply::find($id);
        return response()->json($supply);
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
        $supply = Supply::find($id);
        $supply->name = $request->name;
        $supply->code = $request->code;
        $supply->price = $request->price;
        $supply->update();
        return response()->json(["message"=>"Updated successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supply = Supply::find($id);
        $supply->delete();
        return response()->json(["message"=>"Deleted successfully!"]);
    }
}
