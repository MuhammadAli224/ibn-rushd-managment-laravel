<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GuardianResource as ApiGuardianResource;
use App\Models\Guardian;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuardianController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $this->checkUserActive();


            $guardians = Guardian::get();

            return $this->success(
                data: ApiGuardianResource::collection($guardians),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in GuardianController index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }

    private function checkUserActive()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->error(
                message: __('messages.unauthorized'),
                statusCode: 401
            );
        }
        if (!$user->is_active) {
            return $this->error(
                message: __('messages.account_inactive'),
                statusCode: 403
            );
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['nullable', 'email', 'unique:users,email'],
            'phone'       => ['required', 'string', 'unique:users,phone'],
            'password'    => ['required', 'string', 'min:6'],
            'address'     => ['nullable', 'string', 'max:255'],
            'country'     => ['required', 'string', 'max:100'],
            'gender'      => ['required', 'in:male,female'],
            'occupation'  => ['required', 'string', 'max:255'],
            'whatsapp'    => ['required', 'string', 'max:20'],
        ]);

        DB::beginTransaction();

        try {
            // ✅ 1. Create the user and set center_id = 1
            $user = User::create([
                'center_id'   => 1, // fixed center ID
                'name'        => $validated['name'],
                'email'       => $validated['email'] ?? null,
                'phone'       => $validated['phone'],
                'password'    => Hash::make($validated['password']),
                'address'     => $validated['address'] ?? null,
                'country'     => $validated['country'],
                'gender'      => GenderEnum::MALE,
                
            ]);

            // Assign the "Parent" role
            $user->assignRoleAndPermissions(RoleEnum::PARENT);

            $guardian = Guardian::create([
                'user_id'     => $user->id,
                'occupation'  => $validated['occupation'],
                'whatsapp'    => $validated['whatsapp'],
                'created_by'  => auth()->id(),
            ]);

            DB::commit();

            return $this->success(
                data: new ApiGuardianResource($guardian),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in GuardianController store : ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
