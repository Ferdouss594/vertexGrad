<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProjectSubmitted extends Notification
{
    use Queueable;
    protected $project;

    public function __construct(Project $project) { $this->project = $project; }

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable)
    {
        return [
            'title'   => 'New Project Review',
            'message' => 'A new project "'.$this->project->name.'" requires your verification.',
            'url'     => route('manager.dashboard'), // Adjust to your review route
            'icon'    => 'fas fa-file-import',
        ];
    }
}