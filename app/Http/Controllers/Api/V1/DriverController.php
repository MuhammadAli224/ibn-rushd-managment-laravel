<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GuardianResource;
use App\Models\Driver;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $drivers = Driver::get();

            return $this->success(
                data: GuardianResource::collection($drivers),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in StudentsController index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
