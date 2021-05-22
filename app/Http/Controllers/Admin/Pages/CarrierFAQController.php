<?php

namespace App\Http\Controllers\admin\Pages;

use App\CarrierFaq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CarrierFaqController extends Controller
{
     //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrierFaq = CarrierFaq::all();
        return response()->json($carrierFaq);
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
        $carrierFaq = new CarrierFaq();

        $carrierFaq->title = $request->title;
        $carrierFaq->body = $request->body;

        $carrierFaq->save();
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
        $carrierFaq = CarrierFaq::find($id);
        return response()->json($carrierFaq);
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
        $carrierFaq = CarrierFaq::find($id);
        $carrierFaq->title = $request->title;
        $carrierFaq->body = $request->body;
        $carrierFaq->update();
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
        if ($carrierFaq = CarrierFaq::find($id)) {
            $carrierFaq->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }


}
