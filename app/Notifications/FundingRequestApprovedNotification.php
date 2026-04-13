<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FundingRequestApprovedNotification extends Notification
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
            'title' => 'Funding Request Approved',
            'message' => 'Your funding request for project "' . $this->project->name . '" has been approved.',
            'project_id' => $this->project->project_id,
            'project_name' => $this->project->name,
            'url' => route('frontend.projects.show', $this->project, false),
            'icon' => 'fas fa-check-circle',
            'type' => 'funding_request_approved',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}