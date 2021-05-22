<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\ShipperPage;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shiperPage = ShipperPage::all();
        return response()->json($shiperPage);
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
   
        $shiperPage = new ShipperPage();

        $shiperPage->title = $request->title;
        $shiperPage->body = $request->body;

        $shiperPage->save();
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
        $shiperPage = ShipperPage::find($id);
        return response()->json($shiperPage);
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
        $shiperPage = ShipperPage::find($id);
        $shiperPage->title = $request->title;
        $shiperPage->body = $request->body;
        $shiperPage->update();
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
        if ($shiperPage = ShipperPage::find($id)) {
            $shiperPage->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }

}
