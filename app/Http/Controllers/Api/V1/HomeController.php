<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LessonResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class HomeController extends Controller

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

            $todayLessons = $user->todayLessons()->get();
            $weekLessons = $user->thisWeekLessons()->count();
            $monthLessons = $user->thisMonthLessons()->count();
            $tomorrowLessons = $user->tomorrowLessons()->get();
            $upcomingLessons = $user->upcomingLessons()->limit(10)->get();
            $ongoingLessons = $user->ongoingLessons()->get();
            // $user->deposit(10.0);
            // $user->withdraw(20.0);

            return $this->success(
                data: [
                    'today_lessons' => LessonResource::collection($todayLessons),
                    'week_lessons' => $weekLessons,
                    'month_lessons' => $monthLessons,
                    'upcoming_lessons' => LessonResource::collection($upcomingLessons),
                    'tomorrow_lessons' => LessonResource::collection($tomorrowLessons),
                    'ongoing_lessons' => LessonResource::collection($ongoingLessons),
                    'notifications' => $user->unreadNotifications->count(),
                ],
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in HomeController index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
