<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

class ManagerProjectDecisionController extends Controller
{
    protected function currentManager()
    {
        $user = auth('admin')->user();
        abort_unless($user && in_array($user->role, ['Manager', 'Admin']), 403);

        return $user;
    }

 public function index()
{
    $this->currentManager();

    $projects = Project::with([
            'student',
            'reviews.supervisor',
            'finalDecisionMaker',
        ])
        ->whereHas('reviews')
        ->latest('updated_at')
        ->paginate(12);

    return view('admin.projects.final-decisions.index', compact('projects'));
}
    public function show(Project $project)
    {
        $this->currentManager();

        $project->load([
            'student',
            'supervisor',
            'manager',
            'investors',
            'media',
            'reviews.supervisor',
            'finalDecisionMaker',
        ]);

        $averageScore = round($project->reviews->whereNotNull('score')->avg('score') ?? 0, 1);
        $approvedCount = $project->reviews->where('decision', 'approved')->count();
        $revisionCount = $project->reviews->where('decision', 'revision_requested')->count();
        $rejectedCount = $project->reviews->where('decision', 'rejected')->count();

        return view('admin.projects.final-decisions.show', compact(
            'project',
            'averageScore',
            'approvedCount',
            'revisionCount',
            'rejectedCount'
        ));
    }

    public function storeDecision(Request $request, Project $project)
    {
        $manager = $this->currentManager();

        $validated = $request->validate([
            'final_decision' => ['required', 'in:published,revision_requested,rejected'],
            'final_notes' => ['nullable', 'string'],
        ]);

        $project->update([
            'final_decision'   => $validated['final_decision'],
            'final_notes'      => $validated['final_notes'] ?? null,
            'final_decided_at' => now(),
            'final_decided_by' => $manager->id,
            'manager_id'       => $manager->id,
            'status'           => $validated['final_decision'],
        ]);

        if ($project->student) {
            $title = match ($validated['final_decision']) {
                'published' => 'Project Approved for Publishing',
                'revision_requested' => 'Project Requires Revisions',
                'rejected' => 'Project Rejected',
                default => 'Project Final Decision Updated',
            };

            $message = match ($validated['final_decision']) {
                'published' => 'Your project has been finally approved and published by management.',
                'revision_requested' => 'Management requested revisions after reviewing supervisor evaluations.',
                'rejected' => 'Your project was rejected after the final management review.',
                default => 'The final decision for your project has been updated.',
            };

            $project->student->notify(new GeneralNotification([
                'title' => $title,
                'message' => $message,
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-gavel',
            ]));
        }

        return redirect()
            ->route('admin.projects.final-decisions.show', $project->project_id)
            ->with('success', 'Final decision saved successfully.');
    }
}