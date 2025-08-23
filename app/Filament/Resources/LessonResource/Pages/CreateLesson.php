<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\LessonResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use Filament\Notifications\Notification;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\DB;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Lesson Created')
            ->body("Lesson {$this->record->subject->name} has been successfully created.")
            ->success()
            ->send();

        $lesson = $this->record;

        $recipients = collect();

        if ($lesson->teacher) {
            $recipients->push($lesson->teacher->user);
        }

        if ($lesson->driver) {
            $recipients->push($lesson->driver->user);
        }

        if ($lesson->student) {
            $recipients->push($lesson->student->guardian->user);
        }

        $admins = User::role('admin')->get();
        $recipients = $recipients->merge($admins);

        $recipients = $recipients->unique('id');

        $title = "تم انشاء درس جديد{$lesson->subject->name}";
        $message = "تم انشاء درس جديد {$lesson->subject->name} في {$lesson->lesson_date->format('Y-m-d')} لدى {$lesson->teacher->name}  لدى الطالب {$lesson->student->name}";
        \Log::info('Lessone  create:', $this->record->toArray());
        \Log::info('Lessone recipients:', $recipients->toArray());

        foreach ($recipients as $user) {
            $user->notify(new OneSignalNotification($title, $message));

            if ($user->onesignal_token) {
                app(PushNotificationService::class)
                    ->sendToUser($user->onesignal_token, $title, $message);
            }
        }

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::info('Mutate before create:', $data);
        return $data;
    }
}
