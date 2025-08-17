<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalanceResource\Pages;
use App\Filament\Resources\BalanceResource\RelationManagers;
use App\Models\Balance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BalanceResource extends Resource
{
    protected static ?string $model = Balance::class;


        protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-panels::pages/wallet.groupName');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-panels::pages/wallet.balance.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament-panels::pages/wallet.balance.title');
    }

    public static function getLabel(): ?string
    {
        return __('filament-panels::pages/wallet.balance.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('filament-panels::pages/wallet.balance.columns.user'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label(__('filament-panels::pages/wallet.balance.columns.amount'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('month')
                    ->label(__('filament-panels::pages/wallet.balance.columns.month'))
                    ->date('m-Y')

                    ->searchable(),

            ])
            ->filters([


                // Tables\Filters\Filter::make('this_month')
                //     ->label(__('filament-panels::pages/wallet.balance.columns.this_month'))
                //     ->query(fn(Builder $query) => $query->whereMonth('created_at', now()->month)
                //         ->whereYear('created_at', now()->year)),

                Tables\Filters\Filter::make('this_month')
                    ->label(__('filament-panels::pages/wallet.balance.columns.this_month'))
                    ->query(fn(Builder $query) => $query->where('month', now()->format('Y-m'))),

                Tables\Filters\SelectFilter::make('month')
                    ->label('Select Month')
                    ->options(function () {
                        $months = [];
                        $currentYear = now()->year;
                        for ($i = 1; $i <= 12; $i++) {
                            $monthKey = sprintf('%04d-%02d', $currentYear, $i);
                            $months[$monthKey] = \Carbon\Carbon::create($currentYear, $i, 1)->format('F');
                        }
                        return $months;
                    })
                    ->query(function (Builder $query, array $data) {

                        if (!empty($data['value'])) {
                            $query->where('month', $data['value']);
                        }
                    }),



                Tables\Filters\SelectFilter::make('user_id')
                    ->label(__('filament-panels::pages/wallet.balance.columns.user'))
                    ->options(function () {
                        return \App\Models\User::whereHas('balances')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->preload()
                    ->searchable(),

            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBalances::route('/'),
            // 'create' => Pages\CreateBalance::route('/create'),
            'edit' => Pages\EditBalance::route('/{record}/edit'),
        ];
    }
}
