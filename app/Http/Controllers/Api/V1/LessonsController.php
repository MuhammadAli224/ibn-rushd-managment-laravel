<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Api\LessonResource;



class LessonsController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
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

            $date = $request->query('date');
            $lessonsQuery = $user->activeLessons();

            if ($date) {
                $lessons = $lessonsQuery->onDate($date);
            }

            $lessons = $lessonsQuery->get();

            return $this->success(
                data: LessonResource::collection($lessons),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in LessonsController index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
