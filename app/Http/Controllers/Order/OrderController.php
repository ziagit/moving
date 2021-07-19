<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Item;
use App\order;
use App\Locationtype;
use App\Movernumber;
use App\Movingsize;
use App\Movingtype;
use App\Officesize;
use App\Supply;
use App\Vehicle;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('items')->find($id);
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }

    public function locationType()
    {
        $services = Locationtype::all();
        return response()->json($services);
    }
    public function vehicles()
    {
        $services = Vehicle::all();
        return response()->json($services);
    }
    public function moverNumbers()
    {
        $services = Movernumber::all();
        return response()->json($services);
    }
    public function movingSizes()
    {
        $services = Movingsize::all();
        return response()->json($services);
    }
    public function officeSizes()
    {
        $services = Officesize::all();
        return response()->json($services);
    }
    public function movingTypes()
    {
        $services = Movingtype::all();
        return response()->json($services);
    }
    public function movingSupplies()
    {
        $services = Supply::all();
        return response()->json($services);
    }

    public function searchItem(Request $request)
    {
        $keywords = $request->keywords;
        $results = Item::where('name', 'like', '%' . $keywords . '%')
            ->paginate(5);
        return $results;
    }
    public function items()
    {
        $items = Item::all();
        return response()->json($items);
    }
}
