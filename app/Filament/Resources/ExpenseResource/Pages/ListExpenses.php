<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use App\Filament\Resources\ExpenseResource\Widgets\ExpensesOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\ExpenseExporter::class)
               
                ->label(__('filament-panels::pages/wallet.expenses.export'))
                ->fileDisk('public'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ExpensesOverview::class,
        ];
    }
}
