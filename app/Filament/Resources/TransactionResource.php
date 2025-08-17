<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages\ListTransactions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 3;


    public static function getNavigationGroup(): ?string
    {
        return __('filament-panels::pages/wallet.groupName');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-panels::pages/wallet.transactions.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament-panels::pages/wallet.transactions.title');
    }

    public static function getLabel(): ?string
    {
        return __('filament-panels::pages/wallet.transactions.single');
    }

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payable.name')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.user'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('wallet.name')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.wallet'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.type'))
                    ->badge()
                    ->color(fn(Transaction $transaction) => $transaction->type === 'deposit' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.amount'))
                    // ->formatStateUsing(fn(Transaction $transaction) => (int) $transaction->amount / 100)
                    ->badge()
                    ->color(fn(Transaction $transaction) => $transaction->amount > 0 ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\IconColumn::make('confirmed')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.confirmed'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label(__('filament-panels::pages/wallet.transactions.columns.uuid'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(

                //     filament('filament-wallet')->useAccounts ? [
                //     Tables\Filters\SelectFilter::make('payable_id')
                //         ->label(__('filament-panels::pages/wallet.transactions.filters.accounts'))
                //         ->searchable()
                //         ->options(fn() => config('filament-accounts.model')::query()->pluck('name', 'id')->toArray())
                // ] : 

                []
            )
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => ListTransactions::route('/'),
        ];
    }
}
