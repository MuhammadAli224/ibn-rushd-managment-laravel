<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LessonUpdateRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Api\LessonResource;
use App\Models\Lesson;
use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use App\Enums\LessonStatusEnum;

use Illuminate\Support\Facades\DB;

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

            $previousStatus = $lesson->status;

            $validated = $request->validated();

            \Log::info('Validated Data:', $validated);

            $lesson->update($validated);

            if ($lesson->status === \App\Enums\LessonStatusEnum::COMPLETED && !$lesson->transactions()->exists()) {
                DB::transaction(function () use ($lesson) {

                    $teacherAmount = $lesson->lesson_price ?? 0;

                    // -----------------------------
                    // 1. Deduct from guardian's wallet
                    // -----------------------------
                    $lesson->student->guardian->user->forceWithdraw($teacherAmount, [
                        'lesson_id' => $lesson->id,
                        'type' => 'lesson_payment',
                    ]);

                    // -----------------------------
                    // 2. Deposit to teacher
                    // -----------------------------
                    $lesson->teacher->user->deposit($teacherAmount, [
                        'lesson_id' => $lesson->id,
                        'type' => 'lesson_earning',
                    ]);


                    // -----------------------------
                    // 3. Update teacher balance
                    // -----------------------------
                    $month = $lesson->lesson_date?->format('Y-m') ?? now()->format('Y-m');
                    $balance = \App\Models\Balance::firstOrNew([
                        'user_id' => $lesson->teacher->user->id,
                        'month' => $month,
                    ]);

                    $balance->amount += $teacherAmount;
                    $balance->save();

                    // -----------------------------
                    // 4. Notify teacher about the transaction
                    // -----------------------------

                    $title = "اكتملت الحصة: {$lesson->subject->name}";
                    $message = "تم الانتهاء من الحصة {$lesson->subject->name} بتاريخ {$lesson->lesson_date->format('Y-m-d')} وقد حصلت على مبلغ QAR{$teacherAmount}.";
                    \Log::info('Lesson completed:', $lesson->toArray());

                    $lesson->teacher->user->notify(new OneSignalNotification($title, $message));

                    if ($lesson->teacher->user->onesignal_token) {
                        app(PushNotificationService::class)
                            ->sendToUser($lesson->teacher->user->onesignal_token, $title, $message);
                    }
                });
            }

            // if (
            //     $lesson->status === \App\Enums\LessonStatusEnum::COMPLETED->value &&
            //     $previousStatus !== \App\Enums\LessonStatusEnum::COMPLETED->value
            // ) {

            //     if (!$lesson->transactions()->exists()) {

            //         DB::transaction(function () use ($lesson) {
            //             $teacherAmount = $lesson->lesson_price ?? 0;

            //             // 1. Deduct from guardian's wallet
            //             $lesson->student->guardian->user->forceWithdraw($teacherAmount, [
            //                 'lesson_id' => $lesson->id,
            //                 'type' => 'lesson_payment',
            //             ]);

            //             // 2. Deposit to teacher
            //             $lesson->teacher->user->deposit($teacherAmount, [
            //                 'lesson_id' => $lesson->id,
            //                 'type' => 'lesson_earning',
            //             ]);

            //             // 3. Update teacher balance
            //             $month = $lesson->lesson_date?->format('Y-m') ?? now()->format('Y-m');
            //             $balance = \App\Models\Balance::firstOrNew([
            //                 'user_id' => $lesson->teacher->user->id,
            //                 'month' => $month,
            //             ]);
            //             $balance->amount += $teacherAmount;
            //             $balance->save();

            //             // 4. Notify teacher
            //             $title = "اكتملت الحصة: {$lesson->subject->name}";
            //             $message = "تم الانتهاء من الحصة {$lesson->subject->name} بتاريخ {$lesson->lesson_date->format('Y-m-d')} وقد حصلت على مبلغ QAR{$teacherAmount}.";

            //             \Log::info('Lesson completed via API:', $lesson->toArray());

            //             $lesson->teacher->user->notify(new \App\Notifications\OneSignalNotification($title, $message));

            //             if ($lesson->teacher->user->onesignal_token) {
            //                 app(\App\Services\PushNotificationService::class)
            //                     ->sendToUser($lesson->teacher->user->onesignal_token, $title, $message);
            //             }
            //         });
            //     }
            // }

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
