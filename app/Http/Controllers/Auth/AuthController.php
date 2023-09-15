<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showUserLists()
    {
        // $users = User::when(Auth::user()->role !== "admin", function ($query) {
        //     $query->where("id", Auth::id());
        // })->latest("id")->get();

        if (Auth::user()->role !== "admin") {
            return response()->json([
                "message" => "You Are Not Allowed"
            ]);
        }

        $users = User::all();
        return response()->json([
            "users" => $users
        ]);
    }

    public function getYourProfile()
    {
        // $ = User::where("id", Auth::id())->latest("id")->get();
        $user = Auth::user();

        return response()->json([
            "user" => $user
        ]);
    }

    public function checkUserProfile($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                "error" => "User not found"
            ], 404);
        }

        return response()->json([
            "user" => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:20",
            "phone" => "nullable|min:8",
            "date_of_birth" => "nullable",
            "gender" => "required",
            "address" => "nullable",
            "email" => "email|required|unique:users",
            "password" => "required|confirmed|min:6",
            "role" => "required",
            'user_photo' => "nullable",
        ]);

        Gate::authorize("admin-only");

        $user = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
            "address" => $request->address,
            'role' => $request->role,
            "banned" => false,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "user_photo" => $request->user_photo
        ]);


        return response()->json([
            "message" => "user register successfully",
            "data" => $user
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:20",
            "phone" => "nullable|min:8",
            "date_of_birth" => "nullable",
            // "gender" => "required",
            "address" => "nullable",
            'user_photo' => "nullable",
        ]);

        // Gate::authorize("admin-only");
        $user = User::find(Auth::id());
        if (is_null($user)) {
            return response()->json([
                "message" => "user not found"
            ]);
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->date_of_birth;
        }
        if ($request->has('gender')) {
            $user->gender = $request->gender;
        }
        if ($request->has('user_photo')) {
            $user->user_photo = $request->user_photo;
        }

        $user->update();

        //         $user = User::find(Auth::id())->update([
        //     "name" => $request->name,
        //     "phone" => $request->phone,
        //     "date_of_birth" => $request->date_of_birth,
        //     "gender" => $request->gender,
        //     "address" => $request->address,
        //     "user_photo" => $request->user_photo
        // ]);


        return response()->json([
            "message" => "update user successfully",
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


    public function banUser(Request $request, $id)
    {
        Gate::authorize("admin-only");
        $user = User::find($id);
        $user->banned = true;
        $user->update();

        return response()->json(['message' => 'User has been banned']);
    }

    public function unbanUser(Request $request, $id)
    {
        Gate::authorize("admin-only");
        $user = User::find($id);
        $user->banned = false;
        $user->update();

        return response()->json(['message' => 'User has been unbanned']);
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

        // Gate::authorize("admin-only");

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            "message" => "Password Updated",
        ]);
    }
}
