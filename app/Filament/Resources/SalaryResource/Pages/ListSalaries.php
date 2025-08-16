<?php

namespace App\Filament\Resources\SalaryResource\Pages;

use App\Filament\Resources\SalaryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('calculate_salary')
                ->label(__('filament-panels::pages/wallet.salary.calculate_salary'))
                ->color('success')
                ->action(function () {
                    $thisMonth = now()->format('Y-m');

                    DB::transaction(function () use ($thisMonth) {
                        $balances = \App\Models\Balance::where('month', $thisMonth)->get();

                        foreach ($balances as $balance) {
                            $teacherUser = $balance->user;
                            $center = $teacherUser->center;
                            $teacher = $teacherUser->teacher;
                            $totalEarnings = $balance->amount;

                            if ($teacher->commission_type === 'fixed') {
                                $percentage = $teacher->commission ?? 50;

                                $teacherSalary = ($totalEarnings * $percentage) / 100;

                                $centerCommissionPercentage = 100 - $percentage;
                                $centerCommissionValue      = $totalEarnings - $teacherSalary;
                            } else {
                                $teacherSalary = $center->calculateTeacherCommission($totalEarnings);
                                $centerCommissionPercentage = $center->calculateCenterCommission($totalEarnings);
                                $centerCommissionValue      = $totalEarnings - $teacherSalary;
                            }

                            \App\Models\Salary::updateOrCreate(
                                [
                                    'user_id' => $teacherUser->id,
                                    'month' => $thisMonth,
                                ],
                                [
                                    'amount' => $teacherSalary,
                                    'type' => $teacher->commission_type === 'fixed' ? 'fixed' : 'commission',
                                    'salary_date' => now(),
                                    'is_paid' => false,
                                    'center_commession_value'       => $centerCommissionValue,
                                    'center_commession_percentage'  => $centerCommissionPercentage,
                                    'notes' => 'Monthly salary for ' . $thisMonth,
                                ]
                            );

                            $centerAmount = $totalEarnings - $teacherSalary;

                            \App\Models\CenterEarning::create([
                                'center_id' => $center->id,
                                'amount' => $centerAmount,
                                'source' => 'lesson',
                                'earning_date' => now(),
                            ]);
                        }
                    });
                })
                ->requiresConfirmation()

        ];
    }
}
