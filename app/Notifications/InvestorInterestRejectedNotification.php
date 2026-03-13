<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvestorInterestRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public $project) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Investment Interest Rejected',
            'message' => 'Your interest in project "' . $this->project->name . '" was not approved.',
            'project_id' => $this->project->project_id,
            'project_name' => $this->project->name,
            'url' => route('frontend.projects.show', $this->project),
            'icon' => 'fas fa-times-circle',
        ];
    }
}