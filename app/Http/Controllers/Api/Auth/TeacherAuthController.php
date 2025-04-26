<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required'
        ]);
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $teacher = Teacher::where($fieldType, $request->login)->first();

        if (! $teacher || ! Hash::check($request->password, $teacher->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $teacher->createToken('teacher-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'teacher' => $teacher
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('teacher_api')->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $teacher = Teacher::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $teacher->createToken('teacher-token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'token'   => $token,
            'teacher' => $teacher,
        ], 201);
    }
}
