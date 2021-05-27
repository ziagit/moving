<?php

namespace App\Http\Controllers\Shipper;

use App\Address;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper;
use App\User;
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
        $orders = Order::where('shipper_id', $shipper->id)->orderBy('id', 'DESC')->get();
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
            $shipper = $this->createShipper($request, $customer['id']);
            return [
                'message' => 'Thank you! your card added successfully.',
                'shipper' => $shipper,
                'status' => false,
                'email' => $request->email
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
        return null;
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
        $user = JWTAuth::user()->id;
        $shipper = Shipper::where('user_id', $user)->first();
        if ($shipper) {
            $shipper->first_name = $request->name;
            $shipper->user_id = Auth::user()->id;
            $shipper->stripe_customer_id = $customerId;
            $shipper->contact_id = $this->updateContact($request);
            $shipper->address_id = $this->updateAddress($request);
            $shipper->update();
            return $shipper->id;
        }
        $shipper = new Shipper();
        $shipper->first_name = $request->name;
        $shipper->user_id = Auth::user()->id;
        $shipper->stripe_customer_id = $customerId;
        $shipper->contact_id = $this->createContact($request);
        $shipper->address_id = $this->createAddress($request);
        $shipper->save();
        return $shipper->id;
    }
    public function createContact($request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = JWTAuth::user()->phone;
        $contact->save();
        $user = JWTAuth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();
        return $contact->id;
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
    public function updateContact($request)
    {
        $contact = Contact::where('email', $request->email)->first();
        if ($contact) {
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = JWTAuth::user()->phone;
            $contact->update();
            $user = JWTAuth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();
            return $contact->id;
        }
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
