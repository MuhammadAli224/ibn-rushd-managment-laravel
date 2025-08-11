<?php

namespace App\Filament\Resources\ExpenseResource\Widgets;

use App\Models\Expense;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpensesOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $todayTotal = Expense::whereDate('date', today())->sum('amount');

        $weekTotal = Expense::whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->sum('amount');

        $monthTotal = Expense::whereMonth('created_at', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $last30Days = collect(range(29, 0))
            ->map(fn($i) => Expense::whereDate('date', today()->subDays($i))->sum('amount'))
            ->toArray();

        return [
            Stat::make(__('filament-panels::pages/wallet.expenses.widgets.expenses_title.today'), number_format($todayTotal, 2))
                ->description(__('filament-panels::pages/wallet.expenses.widgets.expenses_overview.today'))
                ->color('danger')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before),

            Stat::make(__('filament-panels::pages/wallet.expenses.widgets.expenses_title.this_week'), number_format($weekTotal, 2))
                ->description(__('filament-panels::pages/wallet.expenses.widgets.expenses_overview.this_week'))
                ->color('warning')
                ->descriptionIcon('heroicon-m-calendar-days', IconPosition::Before),

            Stat::make(__('filament-panels::pages/wallet.expenses.widgets.expenses_title.this_month'), number_format($monthTotal, 2))
                ->description(__('filament-panels::pages/wallet.expenses.widgets.expenses_overview.this_month'))
                ->color('success')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before)
                ->chart($last30Days),
        ];
    }
}
