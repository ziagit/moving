<?php

namespace App\Http\Controllers\Admin\Carriers;

use App\Address;
use App\Carrier;
use App\Contact;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $carrier = Carrier::with('user')->paginate(5);
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
            'phone' => 'required|unique:contacts',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
        ]);
        $contactId = $this->storeContact($request);
        $addressId = $this->storeAddress($request);
        try {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logo_name = time() . '.' . $file->getClientOriginalName();
                $file->move(public_path('images/uploads'), $logo_name);
            } else {
                $logo_name = "undefined";
            }
        } catch (Exception $e) {
            die('File did not upload: ' . $e->getMessage());
        }
        try {
            if ($request->hasFile('insurance_papers')) {
                $file = $request->file('insurance_papers');
                $insurance_papers_name = time() . '.' . $file->getClientOriginalName();
                $file->move(public_path('images/uploads'), $insurance_papers_name);
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
                $file->move(public_path('images/uploads'), $business_license_name);
            } else {
                $business_license_name = "undefined";
            }
        } catch (Exception $e) {
            die('File did not upload: ' . $e->getMessage());
        }

        $carrier = new Carrier();
        $carrier->first_name = $request->first_name;
        $carrier->last_name = $request->last_name;
        $carrier->year_established = $request->year_established;
        $carrier->employees = $request->employees;
        $carrier->insurance_papers = $insurance_papers_name;
        $carrier->business_license = $business_license_name;
        $carrier->website = $request->website;
        $carrier->company = $request->company;
        $carrier->detail = $request->detail;
        $carrier->logo = $logo_name;
        $carrier->address_id = $addressId;
        $carrier->contact_id = $contactId;

        $carrier->save();

        return response()->json(["message" => "Saved successfully!"], 200);
    }

    public function storeContact($request)
    {
        $contact = new Contact();
        $contact->name = $request->last_name;
        $contact->phone = $request->phone;
        $contact->email = JWTAuth::user()->email;
        $contact->save();
        return $contact->id;
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
        ]);
        $addressId = $this->updateAddress($request);
        $carrier = Carrier::find($id);

        if ($request->hasFile('logo')) {

            $old_image_path = public_path('images/uploads/' . $carrier->logo);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
            $file = $request->file('logo');
            $logo_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $logo_name);
        } else {
            $logo_name = $carrier->logo;
        }
        if ($request->hasFile('insurance_papers')) {

            $old_image_path = public_path('images/uploads/' . $carrier->insurance_papers);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
            $file = $request->file('insurance_papers');
            $insurance_papers_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $insurance_papers_name);
        } else {
            $logo_name = $carrier->insurance_papers;
        }
        if ($request->hasFile('business_license')) {

            $old_image_path = public_path('images/uploads/' . $carrier->business_license);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
            $file = $request->file('business_license');
            $business_license_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $business_license_name);
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
        $carrier->update();
        
        $this->updateContact($request);

        return response()->json(["message" => "Updated successfully!"], 200);
    }

    public function updateContact($request)
    {
        $user = User::find($request->userId);
        $user->phone = $request->phone;
        $user->update();
        return $user->id;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrier = Carrier::find($id);
        $carrier->delete();
        return response()->json(["message" => "Deleted successfully!"], 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $carrier = Carrier::where('company', 'like', '%' . $keywords . '%')
            ->with('user')
            ->paginate(10);
        return $carrier;
    }
}
