<?php

namespace App\Http\Controllers\Admin\Shippers;

use App\Http\Controllers\Controller;
use App\Shipper;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereHas('roles', function($q){
            $q->where('name', 'customer');
        })->with('roles')
        ->paginate(5);
        return response()->json($users);
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
        //
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->update();
        return response()->json(["message"=>"Updated."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $shipper = Shipper::where('user_id',$id)->first();
        $shipper->delete();
        return response()->json("Record deleted successfully!",200);
    }

    public function lock(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->update();
        return response()->json(["message"=>"Account stateus changed!"]);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $user = User::where('name', 'like', '%' . $keywords . '%')
            ->orWhereHas('roles', function ($q) use ($keywords) {
                return $q->where('name', 'like', '%' . $keywords . '%');
            })
            ->with('roles')
            ->paginate(10);
        return $user;
    }
}
