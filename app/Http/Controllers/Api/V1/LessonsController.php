<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LessonUpdateRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Api\LessonResource;
use App\Models\Lesson;

class LessonsController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $this->checkUserActive();
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

    public function show($id)
    {
        try {
            $this->checkUserActive();

            $lesson = Lesson::where('id', $id)->first();

            if (!$lesson) {
                return $this->error(
                    message: __('messages.lesson_not_found'),
                    statusCode: 404
                );
            }

            return $this->success(
                data: new LessonResource($lesson),
                message: __('general.get_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in LessonsController show: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }

    public function update(LessonUpdateRequest $request, $id)
    {

        try {
            $this->checkUserActive();

            $lesson = Lesson::find($id);

            if (!$lesson) {
                return $this->error(
                    message: __('messages.lesson_not_found'),
                    statusCode: 404
                );
            }


            $validated = $request->validated();

            \Log::info('Validated Data:', $validated);

            $lesson->update($validated);

            return $this->success(
                data: new LessonResource($lesson),
                message: __('general.update_success')
            );
        } catch (\Exception $e) {
            \Log::error('Error in LessonsController update: ' . $e->getMessage());
            return $this->error(
                message: __('general.update_failed'),
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
