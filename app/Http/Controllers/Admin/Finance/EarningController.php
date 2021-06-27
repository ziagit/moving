<?php

namespace App\Http\Controllers\Admin\Finance;

use App\CarrierEarning;
use App\Earning;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revenue()
    {
        $earnings = Earning::with('order')->paginate(5);
        return response()->json($earnings);
    }
    public function unpaidJobs()
    {
        $earnings = Earning::with('orderDetail')
        ->where('status','unpaid')->paginate(5);
        return response()->json($earnings);
    }
    public function paidJobs()
    {
        $earnings = Earning::with('orderDetail')
        ->where('status','paid')->paginate(5);
        return response()->json($earnings);
    }
    public function refunds()
    {
        $earnings = Earning::with('order')->paginate(5);
        return response()->json($earnings);
    }
    public function payouts()
    {
        $earnings = Earning::with('order')->paginate(5);
        return response()->json($earnings);
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
        $earnings = Earning::with('orderDetail')->find($id);
        return response()->json($earnings);
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
        return "hi";
        $earning = Earning::find($id);
        $earning->status = $request->status;
        $earning->update();
        return response()->json(['message'=>'Earning updated!'],200);
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
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $earnings = Earning::where('id', 'like', '%' . $keywords . '%')
            ->orWhereHas('order', function ($q) use ($keywords) {
                return $q->where('uniqid', 'like', '%' . $keywords . '%');
            })
            ->with('order')
            ->paginate(5);
        return response()->json($earnings);
    }
}
