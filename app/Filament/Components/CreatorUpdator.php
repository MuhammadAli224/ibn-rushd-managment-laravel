<?php

namespace App\Filament\Components;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Column;

class CreatorUpdator
{
    /**
     * Return an array of reusable columns.
     *
     * @return Column[]
     */
    public static function columns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label(__('filament-panels::pages/dashboard.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->label(__('filament-panels::pages/dashboard.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('creator.name')
                ->label(__('filament-panels::pages/dashboard.created_by'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updator.name')
                ->label(__('filament-panels::pages/dashboard.updated_by'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
