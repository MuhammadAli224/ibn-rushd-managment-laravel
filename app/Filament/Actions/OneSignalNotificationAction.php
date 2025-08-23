<?php

namespace App\Filament\Actions;

use App\Notifications\OneSignalNotification;
use App\Services\PushNotificationService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class OneSignalNotificationAction extends Action
{
    protected function setUp(): void
    {
        $this->iconButton();
        $this->icon('heroicon-s-bell-alert');
        $this->tooltip(__('filament-panels::pages/general.send_notification'));
        $this->label(__('filament-panels::pages/general.send_notification'));
        $this->form(function ($record) {
            return [
                TextInput::make('title')
                  
                    ->label(__('filament-panels::pages/general.notification_title'))

                    ->required(),


                TextInput::make('message')
                    ->label(__('filament-panels::pages/general.notification_message'))

                    ->required(),


            ];
        });

        $this->action(function ($record, array $data) {



            if (class_exists(OneSignalNotification::class)) {
                $record->notify(new OneSignalNotification($data['title'], $data['message']));
            }

            if ($record->onesignal_token) {
                    app(PushNotificationService::class)
                        ->sendToUser($record->onesignal_token, $data['title'], $data['message']);
                }

            // $record->notify(new OneSignalNotification($data['title'], $data['message']));



            // if ($record->onesignal_token) {
            //     app(PushNotificationService::class)
            //         ->sendToUser($record->onesignal_token, $data['title'], $data['message']);
            // }

           Notification::make()
                    ->title(__('filament-panels::pages/general.notification'))
                    ->body(__('filament-panels::pages/general.notifications_sent_successfully'))
                    ->success()
                    ->send();
        });
    }
}
