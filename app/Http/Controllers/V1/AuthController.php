<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientRegisterRequest;
use App\Http\Requests\Api\ClientUserRegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(LoginRequest $request, PushNotificationService $pushService)
    {

        $user = User::whereEmailOrPhone($request->input('login'))
            ->active()
            ->first();

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



            $title = __('notification.new_login');
            $message = __('notification.new_login_notification') . $request->device_name;
            $user->notify(new OneSignalNotification($title, $message));

            $pushService->sendToUser($user->fcm_token, $title, $message);
        }
        // if ($user->tokens()->exists()) {
        //     return $this->error(
        //         __('auth.token_exist'),
        //         statusCode: 403,
        //         error: 'Forbidden'
        //     );
        // }

        // if (!$user->hasActiveSubscription() && !$user->isAdmin()) {
        //     return $this->error(message: __('auth.no_active_subscription'), error: 'No Active Subscription');
        // }


        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successToken(
            data: new UserProfileResource($user),
            message: __('auth.login_success'),
            token: $token
        );
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

    public function clientRegister(ClientRegisterRequest $request, PushNotificationService $pushService)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request);
            $user->assignRoleAndPermissions(RoleEnum::OWNER);
            $this->createFreeSubscriptionIfExists($user);
            $branch = $this->createMainBranch($user);
            $this->createMainCategory($branch, $user);
            $token = $user->createToken('auth_token')->plainTextToken;

            if ($request->has('fcm_token')) {
                $title = __('notification.hello');
                $message = __('notification.register_success_notification');
                $user->notify(new OneSignalNotification($title, $message));

                $pushService->sendToUser($user->fcm_token, $title, $message);
            }
            DB::commit();


            return $this->successToken(
                data: new UserProfileResource($user),
                message: __('auth.register_success'),
                token: $token

            );
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error(
                'Client registration failed',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]
            );
            return $this->error(message: __('auth.register_failed'), statusCode: 500, error: $e->getMessage());
        }
    }

    private function createUser(ClientRegisterRequest $request): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'fcm_token' => $request->fcm_token,
            'tax_number' => $request->tax_number,
            'comerical_number' => $request->comerical_number,
        ]);
    }



    private function createFreeSubscriptionIfExists(User $user): void
    {
        $plan = Plan::where('monthly_price', 0)->first();
        if ($plan) {
            $user->subscriptions()->create([
                'plan_id'   => $plan->id,
                'starts_at' => now(),
                'end_at'    => now()->addDays($plan->trial_days),
                'is_active' => true,
                'price'     => $plan->monthly_price,
                'is_trial'  => true,
                'connect_zatca_1' => $plan->connect_zatca_1,
                'connect_zatca_2' => $plan->connect_zatca_2,
                'devices_limit' => $plan->devices_limit,
                'users_limit' => $plan->users_limit,
                'branches_limit' => $plan->branches_limit,
                'product_limit' => $plan->product_limit,
                'invoices_limit' => $plan->invoices_limit,
                'supported_printers' => $plan->supported_printers,
                'duration_days' => $plan->trial_days ?? 14,


            ]);
        }
    }

    private function createMainBranch(User $user): Branch
    {
        return Branch::create([
            'name'              => 'الفرع الرئيسي',
            'user_id'           => $user->id,
            'tax_number'        => $user->tax_number,
            'comerical_number'  => $user->comerical_number,
            'zip_code'          => '0000',
            'street'            => '',
            'city_id'           => 1,
            'district_id'       => 10100003002,
            'building_number'   => '123',
            'secondary_number'  => '456',
            'is_active'         => true,
            'created_by'        => $user->id,
            'updated_by'        => $user->id,
        ]);
    }

    private function createMainCategory(Branch $branch, User $user): void
    {
        Category::create([
            'branch_id'   => $branch->id,
            'name'        => ['en' => 'Main Category', 'ar' => 'القائمة الرئيسية'],
            'is_active'   => true,
            'is_primary'  => true,
            'created_by'  => $user->id,
            'updated_by'  => $user->id,
        ]);
    }
}
