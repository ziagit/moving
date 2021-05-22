<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class TimeController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {
        /* if ($date == date('d')) {
            return $this->getTimes($date);
        } else { */
            $time = Time::all();
            return response()->json($time);
      //  }
    }
    public function getTimes($date)
    {
        $currentTime = date('h:i');
        $x = "9:30";
        $times = Time::all();
        $myTimes=[];
        foreach($times as $time){
            return strtotime($time);
            if(strtotime($time)>$currentTime){
                return 'HI';//array_push($myTimes, $time);
            }else{
                return "fuck";
            }
        }
        return "how";
        return $myTimes;

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
