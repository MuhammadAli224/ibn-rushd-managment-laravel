<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function updateFcmToken(Request $request)
{
    $request->validate([
        'fcm_token' => 'required|string',
    ]);

    $user = auth('teacher')->user();
    $user->fcm_token = $request->fcm_token;
    $user->save();

    return response()->json(['message' => 'FCM token updated successfully']);
}


    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $data = $request->validate([
            'name'            => 'sometimes|string|max:255',
            'email'           => 'sometimes|email|unique:teachers,email,' . $teacher->id,
            'phone'           => 'sometimes|string|unique:teachers,phone,' . $teacher->id,
            'address'         => 'sometimes|string',
            'national_id'     => 'nullable|string|unique:teachers,national_id,' . $teacher->id,
            'gender'          => 'in:male,female',
            'date_of_birth'   => 'sometimes|date',
            'qualification'   => 'sometimes|string',
            'specialization'  => 'sometimes|string',
            'experience'      => 'sometimes|string',
            'status'          => 'in:active,inactive',
            'profile_picture' => 'nullable|file|image|max:2048',
            'password'        => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('teachers', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['updated_by'] = auth()->id();

        $teacher->update($data);

        return response()->json([
            'message' => 'Teacher updated successfully',
            'teacher' => $teacher,
        ]);
    }
}
