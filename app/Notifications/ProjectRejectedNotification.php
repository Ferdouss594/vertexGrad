<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectRejectedNotification extends Notification
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
            'title'        => 'Project Rejected',
            'message'      => 'Your project "' . $this->project->name . '" was reviewed and rejected.',
            'project_id'   => $this->project->project_id,
            'project_name' => $this->project->name,
            'url'          => route('frontend.projects.show', $this->project),
            'icon'         => 'fas fa-times-circle',
        ];
    }
}