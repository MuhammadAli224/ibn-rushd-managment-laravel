<?php

namespace App\Filament\Resources;

use App\Filament\Actions\WalletAction;
use App\Filament\Resources\WalletResource\Pages;
use App\Filament\Resources\WalletResource\RelationManagers;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-panels::pages/wallet.groupName');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-panels::pages/wallet.wallets.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament-panels::pages/wallet.wallets.title');
    }

    public static function getLabel(): ?string
    {
        return __('filament-panels::pages/wallet.wallets.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::pages/wallet.wallets.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('holder.name')
                    ->label(__('filament-panels::pages/wallet.wallets.columns.user'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-panels::pages/wallet.wallets.columns.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label(__('filament-panels::pages/wallet.wallets.columns.balance'))
                    ->badge()
                    // ->numeric(2)
                    // ->money('QAR', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label(__('filament-panels::pages/wallet.wallets.columns.uuid'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                []

            )
            ->actions([
                WalletAction::make('wallet'),
            ])
        ;
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
            'index' => Pages\ListWallets::route('/'),

        ];
    }
}
