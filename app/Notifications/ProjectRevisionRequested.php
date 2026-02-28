<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectRevisionRequested extends Notification
{
    use Queueable;
    protected $project;
    protected $reason;

    public function __construct(Project $project, $reason = '') { 
        $this->project = $project; 
        $this->reason = $reason;
    }

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable)
    {
        return [
            'title'   => 'Revision Required',
            'message' => 'Manager requested changes for "'.$this->project->name.'". Reason: '.$this->reason,
            'url'     => route('dashboard.academic'),
            'icon'    => 'fas fa-exclamation-triangle',
        ];
    }
}