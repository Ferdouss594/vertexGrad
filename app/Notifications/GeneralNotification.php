<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected array $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => $this->details['title'] ?? 'Notification',
            'message' => $this->details['message'] ?? '',
            'url'     => $this->details['url'] ?? '#',
            'icon'    => $this->details['icon'] ?? 'fas fa-info-circle',
            'type'    => $this->details['type'] ?? 'general',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}