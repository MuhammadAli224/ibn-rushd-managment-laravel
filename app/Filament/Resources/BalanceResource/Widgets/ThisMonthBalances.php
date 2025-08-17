<?php

namespace App\Filament\Resources\BalanceResource\Widgets;

use App\Models\Balance;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThisMonthBalances extends BaseWidget
{

  
    protected function getStats(): array
    {
        $month = now()->format('Y-m');

        $balances = Balance::where('month', $month)->get();

        return [
            Stat::make(__('filament-panels::pages/wallet.balance.widgets.balance_overview.this_month'), $balances->sum('amount'))
                ->description(__('filament-panels::pages/wallet.balance.widgets.balance_title.this_month'))
                ->color('danger')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before),
        ];
    }
}
