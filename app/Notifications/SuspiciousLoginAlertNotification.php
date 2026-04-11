<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspiciousLoginAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $ip,
        public string $browser,
        public string $os,
        public string $device
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New sign-in detected on your VertexGrad account')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('We detected a sign-in from a device or environment that looks new.')
            ->line('IP: '.$this->ip)
            ->line('Browser: '.$this->browser)
            ->line('OS: '.$this->os)
            ->line('Device: '.$this->device)
            ->line('If this was you, no action is needed.')
            ->line('If this was not you, please reset your password immediately.');
    }
}