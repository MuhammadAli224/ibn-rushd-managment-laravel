<?php

namespace App\Http\Controllers\Api\V1;

use App\Filament\Resources\GuardianResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GuardianResource as ApiGuardianResource;
use App\Models\Guardian;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $this->checkUserActive();

            $user = auth()->user();

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
}
