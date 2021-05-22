<?php

namespace App\Http\Controllers\Admin\Lookups;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(5);
        return response()->json($items);
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
        $item = new Item();
        $item->name = $request->name;
        $item->code = $request->code;
        $item->moving_cost = $request->hours_to_move;
        $item->disposal_fee = $request->disposal_fee;
        $item->save();
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
        $item = Item::find($id);
        return response()->json($item);
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
        $item = Item::find($id);
        $item->name = $request->name;
        $item->code = $request->code;
        $item->moving_cost = $request->hours_to_move;
        $item->disposal_fee = $request->disposal_fee;
        $item->update();
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
        $size = Item::find($id);
        $size->delete();
        return response()->json(["message"=>"Deleted successfully!"]);
    }
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $items = Item::where('name', 'like', '%' . $keywords . '%')
            ->paginate(5);
        return $items;
    }
}
