<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Enums\LessonStatusEnum;
use App\Filament\Resources\LessonResource;
use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }



    protected function afterSave(): void
    {

        $lesson = $this->record;
        if ($lesson->status !== \App\Enums\LessonStatusEnum::COMPLETED) {
            return;
        }
        if ($lesson->transactions()->exists()) {
            return;
        }



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
        $this->dispatch('refresh');
    }
}
