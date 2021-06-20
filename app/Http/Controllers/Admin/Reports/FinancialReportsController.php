<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Earning;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialReportsController extends Controller
{
    public function index(){
        $order = Earning::with('order')->get();
        return response()->json($order);
    }
    public function show($id){
        $earning = Earning::with('order')->find($id);
        return response()->json($earning);
    }
    public function filter(Request $request){
        $data = Earning::query();
        if($request->from !=null){
            $data->where('created_at','>=', $request->input('from'));
        }
        if($request->to !=null){
            $data->where('created_at','<=', $request->input('to'));
        }
        if($request->status!=null){
            $data->where('status',$request->input('status'));
        }
        $res= $data->with('order')->get();
        return response()->json($res);
    }
}
