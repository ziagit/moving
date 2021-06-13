<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Earning;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialReportsController extends Controller
{
    public function index(){
        $month = date('m');
        $order = Earning::whereMonth('created_at', $month)->with('order')->get();
        return response()->json($order);
    }
    public function show($id){
        $earning = Earning::with('order')->find($id);
        return response()->json($earning);
    }
    public function filter(Request $request){
        $data = Earning::query();
        if($request->month !=null){
            $data->whereMonth('created_at', $request->input('month'));
        }
        if($request->status!=null){
            $data->where('status',$request->input('status'));
        }
        $res= $data->with('order')->get();
        return response()->json($res);
    }
}
