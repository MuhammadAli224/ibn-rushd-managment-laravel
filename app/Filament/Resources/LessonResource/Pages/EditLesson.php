<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Enums\LessonStatusEnum;
use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
        /** @var Lesson $lesson */
        $lesson = $this->record;
        // \dd($lesson->status === \App\Enums\LessonStatusEnum::COMPLETED);
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
}
