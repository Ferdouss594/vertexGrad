<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public $project)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'        => 'Project Approved 🎉',
            'message'      => 'Congratulations! Your project "' . $this->project->name . '" has been approved. Please upload images and videos for your project to complete it and showcase it professionally.',
            'project_id'   => $this->project->project_id,
            'project_name' => $this->project->name,
            'url'          => route('frontend.projects.show', $this->project, false),
            'icon'         => 'fas fa-upload',
            'type'         => 'project_approved_notification',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}