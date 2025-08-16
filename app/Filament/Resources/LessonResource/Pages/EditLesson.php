<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Enums\LessonStatusEnum;
use App\Filament\Resources\LessonResource;
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
        });
    }
}
