<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class SupervisorProjectController extends Controller
{
    protected function currentSupervisor()
    {
        $user = auth('admin')->user();
        abort_unless($user && $user->role === 'Supervisor', 403);

        return $user;
    }

    public function index()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->where('supervisor_id', $user->id)
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.index', compact('projects'));
    }

    public function pending()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->where('supervisor_id', $user->id)
            ->where(function ($query) {
                $query->whereIn('status', ['Pending', 'pending', 'awaiting_manual_review', 'scan_requested'])
                      ->orWhereNull('supervisor_status')
                      ->orWhereIn('supervisor_status', ['pending', 'under_review']);
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.pending', compact('projects'));
    }

    public function approved()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->where('supervisor_id', $user->id)
            ->where(function ($query) {
                $query->whereIn('supervisor_status', ['approved'])
                      ->orWhereIn('supervisor_decision', ['approved'])
                      ->orWhereIn('status', ['approved', 'Approved']);
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.approved', compact('projects'));
    }

    public function revisions()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->where('supervisor_id', $user->id)
            ->where(function ($query) {
                $query->where('supervisor_status', 'revision_requested')
                      ->orWhere('supervisor_decision', 'revision_requested');
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.revisions', compact('projects'));
    }

    public function show(Project $project)
{
    $user = $this->currentSupervisor();

    abort_unless($project->supervisor_id == $user->id, 403);

    $project->load([
        'student',
        'supervisor',
        'manager',
        'investors',
        'media',
    ]);

    return view('supervisor.projects.show', compact('project'));
}

    public function submitReview(Request $request, Project $project)
    {
        $user = $this->currentSupervisor();

        abort_unless($project->supervisor_id == $user->id, 403);

        $validated = $request->validate([
            'supervisor_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'supervisor_notes' => ['required', 'string'],
            'supervisor_decision' => ['required', 'in:approved,revision_requested,rejected'],
        ]);

        $project->update([
            'supervisor_status'      => $validated['supervisor_decision'],
            'supervisor_score'       => $validated['supervisor_score'],
            'supervisor_notes'       => $validated['supervisor_notes'],
            'supervisor_decision'    => $validated['supervisor_decision'],
            'supervisor_reviewed_at' => now(),
        ]);

        if ($validated['supervisor_decision'] === 'approved') {
            $project->update(['status' => 'approved']);
        } elseif ($validated['supervisor_decision'] === 'revision_requested') {
            $project->update(['status' => 'awaiting_manual_review']);
        } elseif ($validated['supervisor_decision'] === 'rejected') {
            $project->update(['status' => 'rejected']);
        }

        return redirect()
            ->route('supervisor.projects.show', $project->project_id)
            ->with('success', 'Supervisor review submitted successfully.');
    }
}