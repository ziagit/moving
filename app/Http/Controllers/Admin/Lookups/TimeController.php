<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $times = Time::all();
        return response()->json($times);
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
        $time = new Time();
        $time->time = $request->time;
        $time->date_id = $request->date;
        $time->save();
        return response()->json(['message'=>'Saved successfully!'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $time = Time::find($id);
        return response()->json($time);
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
        $time = Time::find($id);
        $time->time = $request->time;
        $time->date_id = $request->date;
        $time->update();
        return response()->json(['message'=>'Updated successfully!'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $time = Time::find($id);
        $time->delete();
        return response()->json(['message'=>'Deleted successfully!'],200);
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $res = Time::where('time', 'like', '%' . $keywords . '%')
            ->paginate(5);
        return $res;
    }

}
