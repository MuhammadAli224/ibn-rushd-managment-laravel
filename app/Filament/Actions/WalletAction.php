<?php

namespace App\Filament\Actions;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class WalletAction extends Action
{
    protected function setUp(): void
    {
        $this->iconButton();
        $this->icon('heroicon-s-wallet');
        $this->tooltip(__('filament-panels::pages/wallet.wallets.action.title'));
        $this->label(__('filament-panels::pages/wallet.wallets.action.title'));
        $this->form(function ($record) {
            return [
                TextInput::make('current_balance')
                    ->disabled()
                    ->label(__('filament-panels::pages/wallet.wallets.action.current_balance'))
                    ->numeric()
                    ->required()
                   
                    ->default($record->balanceFloatNum),
                Select::make('type')
                    ->searchable()
                    ->default('credit')
                    ->options([
                        'credit' => __('filament-panels::pages/wallet.wallets.action.credit'),
                        'debit' => __('filament-panels::pages/wallet.wallets.action.debit')
                    ])
                    ->label(__('filament-panels::pages/wallet.wallets.action.type'))
                    ->required()
                    ,
                TextInput::make('amount')
                    ->label(__('filament-panels::pages/wallet.wallets.action.amount'))
                    ->numeric()
                    ->required()
                   
                    ->afterStateUpdated(function ($record, $state, Set $set, Get $get) {
                        if ($get('type') == 'debit') {
                            $set('current_balance', $record->balanceFloatNum - $state);
                        } else {
                            $set('current_balance', $record->balanceFloatNum + $state);
                        }
                    })
            ];
        });
        $this->action(function ($record, array $data) {
            if ($data['type'] == 'debit') {
                $record->withdrawFloat($data['amount']);
            } else {
                $record->depositFloat($data['amount']);
            }

            Notification::make()
                ->title(__('filament-panels::pages/wallet.wallets.notification.title'))
                ->body(__('filament-panels::pages/wallet.wallets.notification.message'))
                ->send();
        });
    }
}
