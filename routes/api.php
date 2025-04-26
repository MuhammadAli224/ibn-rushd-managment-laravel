<?php

use App\Http\Controllers\Api\DriversController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\Auth\TeacherAuthController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::prefix('teacher')->group(function () {
//     Route::post('login', [TeacherAuthController::class, 'login']);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('profile', [TeacherAuthController::class, 'profile']);
//         Route::post('logout', [TeacherAuthController::class, 'logout']);
//     });
// });


Route::prefix('teacher')->group(function () {
    Route::post('register', [TeacherAuthController::class, 'register']);
    Route::post('login',    [TeacherAuthController::class, 'login']);
    Route::post('logout',   [TeacherAuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('profile',   [TeacherAuthController::class, 'profile'])->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->put('/teachers/{id}', [TeacherController::class, 'update']);


    Route::post('forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('teachers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    });

    Route::post('reset-password', function (Request $request) {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('teachers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($teacher, $password) {
                $teacher->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    });
});
Route::middleware('auth:sanctum')->post('/teacher/update-fcm-token', [TeacherController::class, 'updateFcmToken']);
Route::middleware('auth:sanctum')->post('/driver/update-fcm-token', [DriversController::class, 'updateFcmToken']);
Route::middleware('auth:sanctum')->post('/user/update-fcm-token', [UserController::class, 'updateFcmToken']);
