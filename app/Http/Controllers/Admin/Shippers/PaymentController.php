<?php

namespace App\Http\Controllers\Admin\Shippers;

use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function store(Request $request)
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
    public function show($customerId)
    {
        try {
            $card = Stripe::cards()->all($customerId);
            return response()->json($card);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
