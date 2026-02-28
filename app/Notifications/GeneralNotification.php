<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        // $details = ['title' => '...', 'message' => '...', 'url' => '...']
        $this->details = $details;
    }

    public function via($notifiable)
    {
        // We store it in the database for the "Bell" icon
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title'   => $this->details['title'],
            'message' => $this->details['message'],
            'url'     => $this->details['url'] ?? '#',
            'icon'    => $this->details['icon'] ?? 'fas fa-info-circle',
        ];
    }
}