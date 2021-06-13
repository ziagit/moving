<?php

namespace App\Http\Controllers\Admin;

use App\Carrier;
use App\Earning;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dailyProjections(){
        $orders = Order::with('addresses')->get();
        return response()->json($orders);
    }
    public function sales(){
        $orders = Earning::all();
        return response()->json($orders);
    }
    public function customers(){
        $shippers = Shipper::all();
        return response()->json($shippers);
    }
    public function movers(){
        $carriers = Carrier::all();
        return response()->json($carriers);
    }
    public function performance(){
        $carriers = Earning::all();
        return response()->json($carriers);
    }
}
