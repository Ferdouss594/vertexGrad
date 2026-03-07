<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectSubmittedNotification extends Notification
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
        'title'        => 'New Project Submitted',
        'message'      => 'A new project was submitted: ' . $this->project->name,
        'project_id'   => $this->project->project_id, // ✅ correct PK
        'project_name' => $this->project->name,
        'url'          => route('admin.projects.show', ['project' => $this->project->project_id]), // ✅ correct param name + value
        'icon'         => 'fas fa-file-upload',
    ];
}
}