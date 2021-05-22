<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=Country::paginate(10);
        return response()->json($countries);
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
            'name' => 'required',
            'code' => 'required',
        ]);

        $country = new Country();

        $country->name = $request->name;
        $country->code = $request->code;

        $country->save();
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
            'code' => 'required'
        ]);
        $country = Country::find($id);
        $country->name = $request->name;
        $country->code = $request->code;

        $country->save();
        return response()->json(["message" => "Updated Successfully."], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($country = Country::find($id)) {
            $country->delete();
            return response()->json(["message" => "Deleted Successfully."], 200);
        }
        return response()->json(["message" => "Data Not Found!"], 404);
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $country = Country::where('name', 'like', '%' . $keywords . '%')
            ->paginate(10);
        return $country;
    }
}
