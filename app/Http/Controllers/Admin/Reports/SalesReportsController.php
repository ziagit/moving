<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Earning;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class SalesReportsController extends Controller
{
    public function index()
    {
        $order = Order::with('addresses', 'shipperContacts', 'items', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->get();
        return response()->json($order);
    }
    public function show($id)
    {
        $order = Order::with('addresses', 'shipperContacts', 'items', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->find($id);
        return response()->json($order);
    }

    public function filter(Request $request)
    {
        $data = Order::query();
        if($request->from!=null){
            $data->where('created_at','>=', $request->input('from'));
        }
        if($request->to!=null){
            $data->where('created_at','<=', $request->input('to'));
        }
        if($request->order_status!=null){
            $data->where('status',$request->input('order_status'));
        }
        if($request->type!=null){
            $type = $request->type;
            $data->whereHas('movingtype',function ($q) use ($type){
                return $q->where('code',$type);
            });
        }
        $res = $data->with('addresses', 'shipperContacts', 'items', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->get();
        return response()->json($res);
    }
}
