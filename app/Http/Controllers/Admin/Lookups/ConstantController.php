<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\ConstStub;

class ConstantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cons = Constant::all();
        return response()->json($cons);
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
        $cons = New Constant();
        $cons->name = $request->name;
        $cons->code = $request->code;
        $cons->value = $request->value;
        $cons->save();
        return response()->json(['message'=>'Saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cons = Constant::find($id);
        return response()->json($cons);
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
        $cons = Constant::find($id);
        $cons->name = $request->name;
        $cons->code = $request->code;
        $cons->value = $request->value;
        $cons->update();
        return response()->json(['message'=>'Updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cons = Constant::find($id);
        $cons->delete();
        return response()->json(['message'=>'Deleted!']);
    }
}
