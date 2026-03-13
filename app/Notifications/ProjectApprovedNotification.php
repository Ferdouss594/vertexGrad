<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApprovedNotification extends Notification
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
            'title'        => 'Project Approved',
            'message'      => 'Your project "' . $this->project->name . '" has been approved and is now active.',
            'project_id'   => $this->project->project_id,
            'project_name' => $this->project->name,
            'url'          => route('frontend.projects.show', $this->project),
            'icon'         => 'fas fa-check-circle',
        ];
    }
}