<?php

namespace App\Http\Controllers\Carrier;

use App\Calendar;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $calendars = Calendar::where('carrier_id', $carrierId)->get();
        return response()->json($calendars);
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
        try {
            $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
            $day = Calendar::where('day', $request->day)->where('carrier_id', $carrierId)->first();
            if ($day) {
                $day->delete();
                return response()->json(Calendar::all());
            }
            $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
            $calendar = new Calendar();
            $calendar->year = $request->year;
            $calendar->month = $request->month;
            $calendar->day = $request->day;
            $calendar->carrier_id = $carrierId;
            $calendar->save();
            return response()->json("Updated successfully!!", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
