<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewInvestmentInterest extends Notification
{
    use Queueable;

    protected Project $project;
    protected string $investorName;

    public function __construct(Project $project, $investorName)
    {
        $this->project = $project;
        $this->investorName = $investorName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => 'New Investor Interest!',
            'message' => $this->investorName . ' is interested in your project "' . $this->project->name . '".',
            'url'     => route('dashboard.academic', [], false),
            'icon'    => 'fas fa-hand-holding-usd',
            'type'    => 'new_investment_interest',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}