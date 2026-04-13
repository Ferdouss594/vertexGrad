<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApproved extends Notification
{
    use Queueable;

    protected Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => 'Project Approved! 🎉',
            'message' => 'Your project "' . $this->project->name . '" has been verified and is now live.',
            'url'     => route('dashboard.academic', [], false),
            'icon'    => 'fas fa-check-double',
            'type'    => 'project_approved',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}