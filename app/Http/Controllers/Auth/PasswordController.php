<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{


    public function update(Request $request)
    {

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', "current_password"],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Gate::authorize("admin-only");

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        $request->user()->currentAccessToken()->delete();


        return response()->json([
            "message" => "Password Updated",
        ]);
        // return back()->with('status', 'password-updated');
    }
}
