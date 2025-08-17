<?php

namespace App\Filament\Resources\SalaryResource\Widgets;

use App\Models\Salary;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThisMonthSalary extends BaseWidget
{
    protected function getStats(): array
    {
        $month = now()->format('Y-m');

        $balances = Salary::where('month', $month)->get();

        return [
            Stat::make(__('filament-panels::pages/wallet.salary.widgets.salary_overview.this_month'), $balances->sum('amount'))
                ->description(__('filament-panels::pages/wallet.salary.widgets.salary_title.this_month'))
                ->color('success')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before),

            Stat::make(__('filament-panels::pages/wallet.salary.widgets.salary_overview.commission'), $balances->sum('center_commession_value'))
                ->description(__('filament-panels::pages/wallet.salary.widgets.salary_title.commission'))
                ->color('warning')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before),
        ];
    }
}
