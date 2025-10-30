<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SubjectResource;
use App\Models\Subject;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $subject = Subject::all();
            return $this->success(
                data: SubjectResource::collection($subject),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in SubjectController index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
