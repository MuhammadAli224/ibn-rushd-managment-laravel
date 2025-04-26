<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
            'fcm_token' => 'nullable|string',

        ]);
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($fieldType, $request->login)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($request->fcm_token) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|max:15|unique:users,phone,' . $user->id,
            'address' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Optional profile image
        ]);

        $user->name = $request->name ?? $user->name;
        $user->phone = $request->phone ?? $user->phone;
        $user->address = $request->address ?? $user->address;

        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->save();

        return response()->json(['message' => 'Profile updated', 'user' => $user]);
    }
}
