<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your VertexGrad Login Verification Code')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Use the following verification code to complete your login:')
            ->line($this->code)
            ->line('This code expires in 10 minutes.')
            ->line('If you did not try to sign in, you can ignore this email.');
    }
}