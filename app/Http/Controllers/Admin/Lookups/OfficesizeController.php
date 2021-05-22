<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use App\Officesize;
use Illuminate\Http\Request;

class OfficesizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Officesize::all();
        return response()->json($sizes);
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
        $size = new Officesize();
        $size->title = $request->title;
        $size->code = $request->code;
        $size->employees = $request->employees;
        $size->hours_to_move = $request->hours_to_move;
        $size->save();
        return response()->json(["message"=>"Saved successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $size = Officesize::find($id);
        return response()->json($size);
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
        $size = Officesize::find($id);
        $size->title = $request->title;
        $size->code = $request->code;
        $size->employees = $request->employees;
        $size->hours_to_move = $request->hours_to_move;
        $size->update();
        return response()->json(["message"=>"Updated successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Officesize::find($id);
        $size->delete();
        return response()->json(["message"=>"Deleted successfully!"]);
    }
}
