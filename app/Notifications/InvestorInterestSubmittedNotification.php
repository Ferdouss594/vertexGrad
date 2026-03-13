<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvestorInterestSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public $project, public $investor) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Investor Interest',
            'message' => $this->investor->name . ' expressed interest in project "' . $this->project->name . '".',
            'project_id' => $this->project->project_id,
            'investor_id' => $this->investor->id,
            'project_name' => $this->project->name,
            'investor_name' => $this->investor->name,
            'url' => route('admin.projects.show', $this->project),
            'icon' => 'fas fa-handshake',
        ];
    }
}