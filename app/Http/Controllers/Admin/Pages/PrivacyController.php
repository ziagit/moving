<?php

namespace App\Http\Controllers\admin\Pages;

use App\Http\Controllers\Controller;
use App\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
     //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privacy = Privacy::all();
        return response()->json($privacy);
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
   
        $privacy = new Privacy();

        $privacy->title = $request->title;
        $privacy->body = $request->body;

        $privacy->save();
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
        $privacy = Privacy::find($id);
        return response()->json($privacy);
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
        $privacy = Privacy::find($id);
        $privacy->title = $request->title;
        $privacy->body = $request->body;
        $privacy->update();
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
        if ($privacy = Privacy::find($id)) {
            $privacy->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }


}
