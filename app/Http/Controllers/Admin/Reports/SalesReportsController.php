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
        $month = date('m');
        $order = Order::whereMonth('created_at', $month)->with('addresses', 'shipperContacts', 'items', 'movingtype', 'movingsize', 'officesize', 'movernumber', 'vehicle', 'supplies', 'jobWithCarrier')->get();
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
        if($request->month!=null){
            $data->whereMonth('created_at', $request->input('month'));
        }
        if($request->order_status!=null){
            $data->where('status',$request->input('order_status'));
        }
        if($request->pickup!=null){
            $pickup = $request->pickup;
            $data->whereHas('addresses',function ($q) use ($pickup){
                return $q->where('city',$pickup);
            });
        }
        if($request->destination!=null){
            $destination = $request->destination;
            $data->whereHas('addresses',function ($q) use ($destination){
                return $q->where('city',$destination);
            });
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
