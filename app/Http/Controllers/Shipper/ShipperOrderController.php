<?php

namespace App\Http\Controllers\Shipper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Job;
use App\Jobstatus;
use App\Order;
use Illuminate\Http\Request;
use App\User;
use Exception;

class ShipperOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
      /*   $user = User::with('shipper')->find(Auth::id())->shipper->id;
        return $user; */
        $shipper = User::with('shipper')->find(Auth::id())->shipper;
        $order = Order::with('addresses')->where('shipper_id',$shipper->id)->orderBy('id','DESC')->get();
        return response()->json($order);
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
        try{
            $orders = Order::with('addresses','items','contact','movingtype','movingsize','officesize','movernumber','vehicle','supplies','jobWithStatus')->find($id);
            return response()->json($orders);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
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
        $order = Order::find($id);
        $order->status = $request->status;
        $order->update();
        return response()->json(['message'=>'Canceled successfully'],200);
/*         if ($request->emails[0] !== $request->emails[1]) {
            foreach ($request->emails as $email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    return $this->notifyUser($user, $id);
                }
            }
        } else {
            $user = User::where('email', $request->emails[0])->first();
            if ($user) {
                return $this->notifyUser($user, $id);
            }
        }
        return $this->notifyShipper($request->emails, $id); */
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
    public function status(){
        return Jobstatus::all()->last();
    }
}
