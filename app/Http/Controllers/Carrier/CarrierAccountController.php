<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CarrierAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user();
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
    public function changeAvatar(Request $request, $id)
    {
        $this->validate($request, [
            'avatar' => 'required',
        ]);
        $user = User::find($id);
        if ($request->hasFile('avatar')) {
            $old_image_path = public_path('images/pub/' . $user->avatar);
            if (file_exists($old_image_path)) {
                //@unlink($old_image_path);
            }
            $file = $request->file('avatar');
            $avatar_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/pub'), $avatar_name);
        } else {
            $avatar_name = $user->avatar;
        }
        $user->avatar = $avatar_name;
        $user->update();
        return response()->json(['message' => 'Updated successfully!'], 200);
    }
    public function update(Request $data, $id)
    {
        if($data->password){
            $validator = Validator::make($data->all(), [
                'password_confirmation' => 'required|same:password',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }
     
        $user = User::find($id);
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->update();
        return response()->json(['message' => 'Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
