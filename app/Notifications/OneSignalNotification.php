<?php

namespace App\Notifications;

use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// implements ShouldQueue
class OneSignalNotification extends Notification
{
    use Queueable;
    protected $title;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }

    public function sendPushToUser($token)
    {
        OneSignalFacade::sendNotificationToUser(
            $this->message,
            $token,
            $url = null,
            $data = null,
            $button = null,
            $schedule = null,
            $this->title,

        );
    }


    public function sendPushToAllUser()
    {
        OneSignalFacade::sendNotificationToAll(
            $this->message,
            $url = null,
            $data = null,
            $button = null,
            $schedule = null,
            $this->title,

        );
    }
}
