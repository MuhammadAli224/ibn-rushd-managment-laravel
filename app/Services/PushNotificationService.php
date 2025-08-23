<?php

namespace App\Services;

use Berkayk\OneSignal\OneSignalFacade;

class PushNotificationService
{
    public function sendToUser(string $playerId, string $title, string $message)
    {
        return OneSignalFacade::sendNotificationToUser(
            $message,
            $playerId,
            null, // URL
            [
                'title' => $title,
                'message' => $message,
            ], // Data
            null, // Buttons
            null, // Schedule
            $title
        );
    }

    public function sendToAll(string $title, string $message)
    {
        //       User::all()->each(function ($user) {
        //     $user->notify(new OneSignalNotification("Big Sale!", "Don't miss our huge sale!"));
        // });

        return OneSignalFacade::sendNotificationToAll(
            $message,
            null,
            null,
            null,
            null,
            $title
        );
    }
}
