<?php

namespace App\Http\Controllers\Shipper;

use App\Address;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper;
use App\User;
use Cartalyst\Stripe\Api\Customers;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCard()
    {
        $customerId = Auth::user()->customer_id;
        if ($customerId) {
            $card = Stripe::cards()->all($customerId);
            return response()->json($card);
        } else {
            return null;
        }
    }
    public function getCustomer()
    {
        $id = Auth::user()->id;
        $shipper = Shipper::where('user_id', $id)->first();
        if ($shipper) {
            if ($shipper->stripe_customer_id) {
                $card = Stripe::cards()->all($shipper->stripe_customer_id);
                return response()->json($card);
            } else {
                return null;
            }
        }
        return null;
    }

    public function getCharges()
    {
        $shipper = User::with('shipper')->find(Auth::id())->shipper;
        $orders = Order::where('shipper_id', $shipper->id)->where('charge_id', '!=', null)->orderBy('id', 'DESC')->get();
        return $orders;

        $res = array();
        $customerId = Auth::user()->customer_id;
        $charges = Stripe::charges()->all(['customer' => $customerId]);
        if ($charges) {
            for ($i = 0; $i < count($orders); $i++) {
                if ($orders[$i]['charge_id'] == $charges['data'][$i]['id']) {
                    $res[$i]['order'] = $orders[$i]['uniqid'];
                    $res[$i]['amount'] = $orders[$i]['uniqid'];
                }
            }
        }
        if ($customerId) {
            $card = Stripe::cards()->all($customerId);
            return response()->json($card);
        } else {
            return null;
        }
    }

    public function createCustomer(Request $request)
    {
        try {
            $customer = Stripe::customers()->create([
                'source' => $request->stripeToken,
                'email' => $request->email,
                'name' => $request->name_oncard,
                'description' => "Payment for moving",
            ]);
            if($customer){
                $shipper = $this->createShipper($request, $customer['id']);
                return [
                    'message' => 'Thank you! your card added successfully.',
                    'shipper' => $shipper,
                    'status' => false,
                    'email' => $request->email
                ];
            }
            return response()->json(['message'=>'Could not create Strip customer'],400);
        
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function checkCustomer()
    {
        $customerId = Auth::user()->customer_id;
        if ($customerId) {
            $customer = Stripe::customers()->find($customerId);
            return $customer['id'];
        } else {
            return null;
        }
    }

    public function createShipper($request, $customerId)
    {
        $user = User::find(Auth::user()->id);
        $user->email = $request->email;
        $user->update();
        $shipper = Shipper::where('user_id', $user->id)->first();
        if ($shipper) {
            $shipper->first_name = $request->name;
            $shipper->stripe_customer_id = $customerId;
            $shipper->address_id = $this->updateAddress($request);
            $shipper->update();
            return $shipper->id;
        }
        $shipper = new Shipper();
        $shipper->first_name = $request->name;
        $shipper->user_id = $user->id;
        $shipper->stripe_customer_id = $customerId;
        $shipper->address_id = $this->createAddress($request);
        $shipper->save();
        return $shipper->id;
    }

    public function createAddress($request)
    {
        $address = new Address();
        $address->street = $request->street;
        $address->street_number = $request->street_number;
        $address->zip = $request->postalcode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->formatted_address = $request->formatted_address;
        $address->save();
        return $address->id;
    }

    public function updateAddress($request)
    {
        $user = Auth::user()->id;
        $shipper = Shipper::where('user_id', $user)->first();
        $address = Address::find($shipper->address_id);
        $address->street = $request->street;
        $address->street_number = $request->street_number;
        $address->zip = $request->postalcode;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->formatted_address = $request->formatted_address;
        $address->update();
        return $address->id;
    }
}
