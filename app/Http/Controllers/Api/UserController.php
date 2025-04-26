<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateFcmToken(Request $request)
{
    $request->validate([
        'fcm_token' => 'required|string',
    ]);

    $user = auth()->user();
    $user->fcm_token = $request->fcm_token;
    $user->save();

    return response()->json(['message' => 'FCM token updated successfully']);
}

}
