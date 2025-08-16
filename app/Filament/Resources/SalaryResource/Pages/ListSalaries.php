<?php

namespace App\Filament\Resources\SalaryResource\Pages;

use App\Filament\Resources\SalaryResource;
use App\Filament\Resources\SalaryResource\Widgets\ThisMonthSalary;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

     protected function getHeaderWidgets(): array
    {
        return [
            ThisMonthSalary::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('calculate_salary')
                ->label(__('filament-panels::pages/wallet.salary.calculate_salary'))
                ->color('success')
                ->form([
                    DatePicker::make('month')
                        ->label(__('filament-panels::pages/wallet.salary.columns.month'))
                        ->helperText(__('filament-panels::pages/wallet.salary.month_helper'))
                        ->placeholder(__('filament-panels::pages/wallet.salary.month_placeholder'))
                        ->minDate(now()->subYear())
                        ->maxDate(now())
                        ->suffixIcon('heroicon-o-calendar-date-range')
                        ->locale('ar')
                        ->displayFormat('Y-m')
                        ->required()
                        ->default(now()) // default current month
                        ->native(false) // show nice UI instead of raw HTML picker
                        ->closeOnDateSelection(),
                ])
                ->action(function (array $data) {

                    $thisMonth = \Carbon\Carbon::parse($data['month'])->format('Y-m');


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
