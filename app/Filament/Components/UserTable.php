<?php

namespace App\Filament\Components;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ToggleColumn;

class UserTable
{
    /**
     * Return an array of reusable columns.
     *
     * @return Column[]
     */
    public static function columns(): array
    {
        return [
            TextColumn::make('user.name')
                    ->label(__('filament-panels::pages/general.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label(__('filament-panels::pages/general.email'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.phone')
                    ->label(__('filament-panels::pages/general.phone'))
                    ->sortable()
                    ->searchable(),

            ToggleColumn::make('user.is_active')
                ->label(__('filament-panels::pages/general.status'))
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
