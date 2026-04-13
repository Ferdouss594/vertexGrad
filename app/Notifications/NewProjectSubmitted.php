<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProjectSubmitted extends Notification
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
            'title'   => 'New Project Review',
            'message' => 'A new project "' . $this->project->name . '" requires your verification.',
            'url'     => route('manager.dashboard', [], false),
            'icon'    => 'fas fa-file-import',
            'type'    => 'new_project_submitted',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}