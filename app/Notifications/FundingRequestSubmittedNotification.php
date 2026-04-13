<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FundingRequestSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public $project, public $investor, public $amount = null)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Funding Request',
            'message' => $this->investor->name . ' submitted a funding request for "' . $this->project->name . '"',
            'project_id' => $this->project->project_id,
            'project_name' => $this->project->name,
            'investor_id' => $this->investor->id,
            'amount' => $this->amount,
            'url' => route('admin.projects.show', ['project' => $this->project->project_id], false),
            'icon' => 'fas fa-hand-holding-usd',
            'type' => 'funding_request_submitted',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}