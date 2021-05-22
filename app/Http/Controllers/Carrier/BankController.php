<?php

namespace App\Http\Controllers\Carrier;

use App\Address;
use App\Bank;
use App\Contact;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $bank = Bank::where('carrier_id',$carrierId)->first();
        return $bank;
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
        $this->validate($request, [
            'currency' => 'required',
            'transit_number' => 'required',
            'institution_number' => 'required',
            'account_number' => 'required',
            'confirm_account_number' => 'required|same:account_number',
           
        ]);
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $bank = new Bank();
        $bank->carrier_id = $carrierId;
        $bank->currency = $request->currency;
        $bank->transit_number = $request->transit_number;
        $bank->institution_number = $request->institution_number;
        $bank->account_number = $request->account_number;

        $bank->save();
        
        return response()->json(["message" => "Saved successfully!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = Bank::with('carrier')->find($id);
        return response()->json($bank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'currency' => 'required',
            'transit_number' => 'required',
            'institution_number' => 'required',
            'account_number' => 'required',
            'confirm_account_number' => 'required|same:account_number',
           
        ]);
        $carrierId = User::with('carrier')->find(Auth::id())->carrier->id;
        $bank =  Bank::find($id);
        $bank->carrier_id = $carrierId;
        $bank->currency = $request->currency;
        $bank->transit_number = $request->transit_number;
        $bank->institution_number = $request->institution_number;
        $bank->account_number = $request->account_number;

        $bank->update();
        
        return response()->json(["message" => "Updated successfully!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::find($id);
        $bank->delete();
        return response()->json(["message" => "Deleted successfully!"]);
    }

}
