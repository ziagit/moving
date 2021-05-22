<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use App\Movingtype;
use Illuminate\Http\Request;

class MovingtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Movingtype::all();
        return response()->json($types);
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
        $type = new Movingtype();
        $type->title = $request->title;
        $type->code = $request->code;
        $type->save();
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
        $type = Movingtype::find($id);
        return response()->json($type);
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
        $type = Movingtype::find($id);
        $type->title = $request->title;
        $type->code = $request->code;
        $type->update();
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
        $type = Movingtype::find($id);
        $type->delete();
        return response()->json(["message"=>"Deleted successfully!"]);
    }
}
