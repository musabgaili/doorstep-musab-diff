<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        // user from auth
        // using sanctum
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:10|unique:users,phone_number,' . Auth::id(),
        ]);
        $user = Auth::user();
        $user->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        logger($request->all());
        $request->validate([
            'password' => 'required|string|min:6',
        ]);
        $user = Auth::user();
        $user->update(['password' => $request->password]);
        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully',
            'user' => $user,
        ]);
    }

    public function getUserData()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);

    }
}
