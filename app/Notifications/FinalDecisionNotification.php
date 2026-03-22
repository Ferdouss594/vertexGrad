<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FinalDecisionNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $decision;
    protected $managerNote;

    public function __construct(Project $project, string $decision, ?string $managerNote = null)
    {
        $this->project = $project;
        $this->decision = $decision;
        $this->managerNote = $managerNote;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = 'Final Decision on Your Project';
        $message = 'A final decision has been made on your project.';

        switch ($this->decision) {
            case 'published':
                $title = 'Project Published';
                $message = '🎉 Your project has been approved and published successfully.';
                break;

            case 'revision':
                $title = 'Project Needs Revision';
                $message = '✏️ Your project needs revisions before final approval.';
                break;

            case 'rejected':
                $title = 'Project Rejected';
                $message = '❌ Your project has been rejected.';
                break;
        }

        return [
            'title' => $title,
            'message' => $message,
            'project_id' => $this->project->project_id,
            'project_title' => $this->project->title ?? 'Project',
            'decision' => $this->decision,
            'manager_note' => $this->managerNote,
            'url' => route('student.projects.show', $this->project->project_id),
        ];
    }
}