<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = $request->user();
            $notifications = $user->unreadNotifications;
            $role = $user->roles;
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'email' => $user->email,
                'notifications' => $notifications,
                'role' => $role
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
