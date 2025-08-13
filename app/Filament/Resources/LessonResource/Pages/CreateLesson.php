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
        $message = "تم انشاء درس جديد {$lesson->subject->name} في {$lesson->start_time} لدى {$lesson->teacher->name}  لدى الطالب {$lesson->student->name}";
        \Log::info('Lessone  create:', $this->record->toArray());
        \Log::info('Lessone recipients:', $recipients->toArray());

        foreach ($recipients as $user) {
            $user->notify(new OneSignalNotification($title, $message));

            if ($user->onesignal_token) {
                app(PushNotificationService::class)
                    ->sendToUser($user->onesignal_token, $title, $message);
            }
        }

        if ($lesson->status === \App\Enums\LessonStatusEnum::COMPLETED) {

            if (!$lesson->transactions()->exists()) {

                $teacherAmount = $lesson->lesson_price;

                // Father pays (deduct from wallet)
                $lesson->student->guardian->user->forceWithdraw($lesson->lesson_price, [
                    'lesson_id' => $lesson->id,
                    'type' => 'lesson_payment',
                ]);

                // Teacher earns
                $lesson->teacher->user->deposit($teacherAmount, [
                    'lesson_id' => $lesson->id,
                    'type' => 'lesson_earning',
                ]);

                // // Owner earns commission
                // $lesson->center->owner->deposit($commissionAmount, [
                //     'lesson_id' => $lesson->id,
                //     'type' => 'commission',
                // ]);

                // Optional: If driver exists, pay driver
                // if ($lesson->driver_id && $lesson->uber_charge) {
                //     $lesson->driver->deposit($lesson->uber_charge, [
                //         'lesson_id' => $lesson->id,
                //         'type' => 'driver_payment',
                //     ]);
                // }
            }
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::info('Mutate before create:', $data);
        return $data;
    }
}
