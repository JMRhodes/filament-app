<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthUserController extends Controller
{
    public function login(Request $request)
    {
        $user_data = $request->validate([
            'email' => 'required|string|email',
            'password' => ['required', Password::default()],
        ]);

        $user = User::where('email', $user_data['email'])->first();

        if (! $user || ! Hash::check($user_data['password'], $user->password)) {
            return response()->json([
                'message' => __('Invalid Credentials'),
            ], 401);
        }

        return response()->json([
            'access_token' => $user->createToken($user->name.'-AuthToken')->plainTextToken,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => __('Logged Out'),
        ]);
    }
}
