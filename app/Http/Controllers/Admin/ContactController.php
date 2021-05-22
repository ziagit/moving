<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Contact::with('carrier','shipper','orders')->paginate(5);
        return response()->json($contact);
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
            'phone' => 'required',
            'email' => 'required|email'
        ]);
        $contact = new Contact();

        $contact->phone = $request->phone;
        $contact->email = $request->email;

        $contact->save();
        return response()->json(["message" => "Saved Successfully."], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);
        $Contact = Contact::find($id);

        $Contact->name = $request->name;
        $Contact->email = $request->email;
        $Contact->email = $request->email;

        $Contact->save();
        return response()->json(["message" => "Saved Successfully."], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($contact = Contact::find($id)) {
            $contact->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $res = Contact::where('name', 'like', '%' . $keywords . '%')
            ->orWhere('email', 'like','%' . $keywords . '%')
            ->with('shipper','carrier','orders')
            ->paginate(5);
        return $res;
/*         $city = Address::where('name', 'like', '%' . $keywords . '%')
            ->orWhereHas('city', function ($q) use ($keywords) {
                return $q->where('name', 'like', '%' . $keywords . '%');
            })
            ->with('city')
            ->paginate(10);
        return $city; */
    }
}
