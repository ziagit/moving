<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use App\Movernumber;
use Illuminate\Http\Request;

class MovernumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mover = Movernumber::all();
        return response()->json($mover);
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
        $mover = new Movernumber();
        $mover->number = $request->number;
        $mover->recommended = $request->recommended;
        $mover->code = $request->code;
        $mover->save();
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
        $mover = Movernumber::find($id);
        return response()->json($mover);
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
        $mover = Movernumber::find($id);
        $mover->number = $request->number;
        $mover->recommended = $request->recommended;
        $mover->code = $request->code;
        $mover->update();
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
        $mover = Movernumber::find($id);
        $mover->delete();
        return response()->json(["message"=>"Deleted successfully!"]);
    }
}
