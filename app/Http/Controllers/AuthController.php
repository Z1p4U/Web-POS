<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         "name" => "required|min:3|max:20",
    //         "email" => "email|required|unique:users",
    //         "password" => "required|confirmed|min:6",
    //     ]);

    //     $user = User::create([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "password" => Hash::make($request->password),
    //     ]);

    //     return response()->json([
    //         "message" => "user register successfully",
    //     ]);
    // }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "email|required",
            "password" => "required|min:6",
        ]);

        if (!Auth::attempt($request->only('email', "password"))) {
            return response()->json([
                "message" => "User Name or Password Wrong",
            ]);
        };

        return Auth::user()->createToken($request->has("device") ? $request->device : 'unknown');
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "logout successful",
        ]);
    }

    public function devices()
    {
        return Auth::user()->tokens;
    }

    public function logoutAll()
    {
        foreach (Auth::user()->tokens as $token) {
            $token->delete();
        }

        return response()->json([
            "message" => "Logout All Successfully",
        ]);
    }
}
