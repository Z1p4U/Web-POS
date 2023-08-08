<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:20",
            "email" => "email|required|unique:users",
            "password" => "required|confirmed|min:6",
            "role" => "required",
            'user_photo' => "nullable",
        ]);

        Gate::authorize("admin-only");

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            'role' => $request->role,
            "user_photo" => $request->user_photo
        ]);


        return response()->json([
            "message" => "user register successfully",
            "data" => $user
        ]);
    }

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

        $token = $request->user()->createToken($request->has("device") ? $request->device : 'unknown');

        return response()->json([
            "message" => "login successfully",
            "device_name" => $token->accessToken->name,
            "token" => $token->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "logout successful",
        ]);
    }

    public function devices()
    {
        return Auth::user()->tokens;
    }

    public function logoutAll(Request $request)
    {
        // foreach (Auth::user()->tokens as $token) {
        //     $token->delete();
        // }

        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "Logout All Successfully",
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', "current_password"],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Gate::authorize("admin-only");

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            "message" => "Password Updated",
        ]);
    }
}
