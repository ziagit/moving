<?php

namespace App\Http\Controllers\Carrier;

use App\Address;
use App\Http\Controllers\Controller;
use App\Carrier;
use App\Contact;
use App\Rate;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Support\Facades\Auth;

class CarrierDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $userId = JWTAuth::user()->id;
        $carrier = Carrier::with('address','user')->where('user_id', $userId)->first();
        return response()->json($carrier);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'employees' => 'required',
            'vehicles' => 'required',
            'hourly_rate' => 'required',
            'company' => 'required',
        ]);
        $addressId = $this->storeAddress($request);

        try {
            if ($request->hasFile('insurance_papers')) {
                $file = $request->file('insurance_papers');
                $insurance_papers_name = time() . '.' . $file->getClientOriginalName();
                $file->move(public_path('images/pub'), $insurance_papers_name);
            } else {
                $insurance_papers_name = "undefined";
            }
        } catch (Exception $e) {
            die('File did not upload: ' . $e->getMessage());
        }
        try {
            if ($request->hasFile('business_license')) {
                $file = $request->file('business_license');
                $business_license_name = time() . '.' . $file->getClientOriginalName();
                $file->move(public_path('images/pub'), $business_license_name);
            } else {
                $business_license_name = "undefined";
            }
        } catch (Exception $e) {
            die('File did not upload: ' . $e->getMessage());
        }

        $carrier = new Carrier();
        $rate = new Rate();

        $carrier->first_name = $request->first_name;
        $carrier->last_name = $request->last_name;
        $carrier->year_established = $request->year_established;
        $carrier->employees = $request->employees;
        $carrier->vehicles = $request->vehicles;
        $carrier->hourly_rate = $request->hourly_rate;
        $carrier->insurance_papers = $insurance_papers_name;
        $carrier->business_license = $business_license_name;
        $carrier->website = $request->website;
        $carrier->company = $request->company;
        $carrier->detail = $request->detail;
        $carrier->address_id = $addressId;
        $carrier->user_id = JWTAuth::user()->id;
        $carrier->save();
        $this->updateUser($request);
        return response()->json(["message" => "Saved successfully!"], 200);
    }

    public function updateUser($request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->email != 'null') {
            $user->email = $request->email;
            $user->update();
        } else {
            $user->phone = $request->phone;
            $user->update();
        }
        return true;
    }
    public function storeAddress($request)
    {
        $address = new Address();
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->address;
        $address->save();
        return $address->id;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carrier = Carrier::with('address', 'user')->find($id);
        return response()->json($carrier);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'employees' => 'required',
            'vehicles' => 'required',
            'company' => 'required',
        ]);
        $addressId = $this->updateAddress($request);
        $carrier = Carrier::find($id);

        if ($request->hasFile('insurance_papers')) {

            $old_image_path = public_path('images/pub/' . $carrier->insurance_papers);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
            $file = $request->file('insurance_papers');
            $insurance_papers_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/pub'), $insurance_papers_name);
        } else {
            $logo_name = $carrier->insurance_papers;
        }
        if ($request->hasFile('business_license')) {
            $old_image_path = public_path('images/pub/' . $carrier->business_license);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
            $file = $request->file('business_license');
            $business_license_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/pub'), $business_license_name);
        } else {
            $logo_name = $carrier->business_license;
        }

        $carrier->first_name = $request->first_name;
        $carrier->last_name = $request->last_name;
        $carrier->year_established = $request->year_established;
        $carrier->employees = $request->employees;
        $carrier->vehicles = $request->vehicles;
        $carrier->hourly_rate = $request->hourly_rate;
        $carrier->insurance_papers = $request->insurance_papers;
        $carrier->business_license = $request->business_license;
        $carrier->website = $request->website;
        $carrier->company = $request->company;
        $carrier->detail = $request->detail;
        $carrier->logo = $logo_name;
        $carrier->address_id = $addressId;
        $carrier->user_id = JWTAuth::user()->id;
        $carrier->update();

        $this->updateContact($request);

        return response()->json(["message" => "Updated successfully!"], 200);
    }

    public function updateContact($request)
    {
        $user = User::find(JWTAuth::user()->id);
        $user->name = $request->last_name;
        $user->phone = $request->phone;
        $user->phone = JWTAuth::user()->phone;
        $user->update();
    }
    public function updateAddress($request)
    {
        $address = Address::find($request->addressId);
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->formatted_address = $request->address;
        $address->update();
        return $address->id;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Carrier::find($id);
        $bank->delete();
        return response()->json(["message" => "Deleted successfully!"]);
    }
}
