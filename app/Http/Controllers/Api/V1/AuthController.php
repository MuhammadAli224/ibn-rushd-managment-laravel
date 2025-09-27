<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(LoginRequest $request, PushNotificationService $pushService)
    {

        try {
            $user = User::whereEmailOrPhone($request->input('login'))

                ->active()
                ->first();
            \Log::error('User found: ' . ($user ? $user->id : 'No user found'));
            // if ($user->tokens()->exists()) {
            //     $user->tokens->each->delete();  
            // }

            if (
                !$user ||
                !Hash::check($request->password, $user->password)
            ) {

                return $this->error(message: __('auth.failed'), error: 'Invalid Credentials');
            }
            if ($request->has('fcm_token')) {
                User::where('fcm_token', $request->fcm_token)
                    ->where('id', '!=', $user->id)
                    ->update(['fcm_token' => null]);

                $user->update(['fcm_token' => $request->fcm_token]);
            }
            if ($request->has('onesignal_token')) {
                User::
                where('onesignal_token', $request->onesignal_token)
                    ->where('id', '!=', $user->id)
                    ->update(['onesignal_token' => null]);

                $user->update(['onesignal_token' => $request->onesignal_token]);



                // $title = __('notification.new_login');
                // $message = __('notification.new_login_notification') . $request->device_name;
                // $user->notify(new OneSignalNotification($title, $message));

                // $pushService->sendToUser($user->onesignal_token, $title, $message);
            }
            // if ($user->tokens()->exists()) {
            //     return $this->error(
            //         __('auth.token_exist'),
            //         statusCode: 403,
            //         error: 'Forbidden'
            //     );
            // }




            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successToken(
                data: new UserProfileResource($user),
                message: __('auth.login_success'),
                token: $token
            );
        } catch (\Exception $e) {
            \Log::error('Error during login: ' . $e->getMessage());
            return $this->error(
                message: __('validation.failed'),
                statusCode: 500,
                error: 'Internal Server Error : ' . $e->getMessage()
            );
        }
    }


    public function logout(Request $request)
    {
        if ($request->user()?->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            $request->user()->update(['fcm_token' => null]);

            return $this->success(data: null, message: __('auth.logout_success'));
        }

        return $this->error(__('auth.logout_error'), 'No token', 403);
    }



    public function profile(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->error(message: __('auth.unauthorized'), statusCode: 401);
        }

        return $this->success(
            new UserProfileResource($user),
            __('auth.get_success')
        );
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = auth()->user();
            $data = $request->validated();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);

            return $this->success(
                data: new UserProfileResource($user),
                message: __('auth.user_updated'),
                statusCode: 200,

            );
        } catch (\Exception $e) {
            \Log::error('Error updating user profile: ' . $e->getMessage());
            return $this->error(
                message: __('auth.error_updateing_profile'),
                statusCode: 500,
                error: 'Internal Server Error : ' . $e->getMessage()
            );
        }
    }
}
