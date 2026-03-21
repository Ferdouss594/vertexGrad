<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMeeting;
use App\Models\ProjectRequest;
use App\Models\ProjectReview;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

class SupervisorProjectController extends Controller
{
    protected function currentSupervisor()
    {
        $user = auth('admin')->user();
        abort_unless($user && $user->role === 'Supervisor', 403);

        return $user;
    }

    protected function authorizeProject(Project $project)
    {
        $this->currentSupervisor();

        abort_unless($project, 404);
    }

    public function index()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with([
                'student',
                'supervisor',
                'reviews' => function ($query) use ($user) {
                    $query->where('supervisor_id', $user->id);
                },
            ])
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.index', compact('projects'));
    }

    public function pending()
    {
        $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->whereIn('status', ['Pending', 'pending', 'awaiting_manual_review', 'scan_requested'])
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.pending', compact('projects'));
    }

    public function approved()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->whereHas('reviews', function ($query) use ($user) {
                $query->where('decision', 'approved')
                    ->where('supervisor_id', $user->id);
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.approved', compact('projects'));
    }

    public function revisions()
    {
        $user = $this->currentSupervisor();

        $projects = Project::with(['student', 'supervisor'])
            ->whereHas('reviews', function ($query) use ($user) {
                $query->whereIn('decision', ['revision_requested', 'rejected'])
                    ->where('supervisor_id', $user->id);
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('supervisor.projects.revisions', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);

        $project->load([
            'student',
            'supervisor',
            'manager',
            'investors',
            'media',
            'meetings',
            'requests.latestResponse',
            'requests.student',
            'reviews.supervisor',
        ]);

        $currentSupervisorReview = ProjectReview::where('project_id', $project->project_id)
            ->where('supervisor_id', auth('admin')->id())
            ->first();

        return view('supervisor.projects.show', compact('project', 'currentSupervisorReview'));
    }

    public function updateSystemVerification(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'frontend_url' => ['nullable', 'url', 'max:255'],
            'backend_url' => ['nullable', 'url', 'max:255'],
            'api_health_url' => ['nullable', 'url', 'max:255'],
            'admin_panel_url' => ['nullable', 'url', 'max:255'],
            'demo_account' => ['nullable', 'string', 'max:255'],
            'demo_password' => ['nullable', 'string', 'max:255'],
            'deployment_notes' => ['nullable', 'string'],
        ]);

        $project->update([
            'frontend_url' => $validated['frontend_url'] ?? null,
            'backend_url' => $validated['backend_url'] ?? null,
            'api_health_url' => $validated['api_health_url'] ?? null,
            'admin_panel_url' => $validated['admin_panel_url'] ?? null,
            'demo_account' => $validated['demo_account'] ?? null,
            'demo_password' => $validated['demo_password'] ?? null,
            'deployment_notes' => $validated['deployment_notes'] ?? null,
        ]);

        if ($project->student) {
            $project->student->notify(new GeneralNotification([
                'title' => 'System Verification Updated',
                'message' => 'The system verification details for your project were updated by a supervisor.',
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-cogs',
            ]));
        }

        return redirect()
            ->route('supervisor.projects.show', $project->project_id)
            ->with('success', 'System verification information updated successfully.');
    }

    public function storeMeeting(Request $request)
    {
        $this->currentSupervisor();

        $validated = $request->validate([
            'project_id'    => ['required', 'integer', 'exists:projects,project_id'],
            'title'         => ['required', 'string', 'max:255'],
            'meeting_type'  => ['required', 'in:online,offline,demo,viva,Review,Discussion'],
            'meeting_link'  => ['nullable', 'url', 'max:255'],
            'meeting_date'  => ['required', 'date'],
            'meeting_time'  => ['required'],
            'notes'         => ['nullable', 'string'],
        ]);

        $project = Project::where('project_id', $validated['project_id'])
            ->with('student')
            ->firstOrFail();

        $meeting = ProjectMeeting::create([
            'project_id'    => $project->project_id,
            'supervisor_id' => auth('admin')->id(),
            'student_id'    => $project->student_id,
            'title'         => $validated['title'],
            'meeting_type'  => $validated['meeting_type'],
            'meeting_link'  => $validated['meeting_link'] ?? null,
            'meeting_date'  => $validated['meeting_date'],
            'meeting_time'  => $validated['meeting_time'],
            'status'        => 'scheduled',
            'notes'         => $validated['notes'] ?? null,
        ]);

        if ($project->student) {
            $project->student->notify(new GeneralNotification([
                'title' => 'New Meeting Scheduled',
                'message' => 'A supervisor scheduled a new meeting for your project: ' . $meeting->title,
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-calendar-alt',
            ]));
        }

        return redirect()
            ->route('supervisor.meetings.index')
            ->with('success', 'Meeting scheduled successfully.');
    }

    public function updateMeetingStatus(Request $request, Project $project, ProjectMeeting $meeting)
    {
        $this->authorizeProject($project);

        abort_unless((int) $meeting->project_id === (int) $project->project_id, 404);

        $validated = $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $meeting->update([
            'status' => $validated['status'],
        ]);

        if ($project->student) {
            $statusText = ucfirst($validated['status']);

            $project->student->notify(new GeneralNotification([
                'title' => 'Meeting Status Updated',
                'message' => "The meeting \"{$meeting->title}\" status was changed to {$statusText}.",
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-calendar-check',
            ]));
        }

        return redirect()
            ->route('supervisor.projects.show', $project->project_id)
            ->with('success', 'Meeting status updated successfully.');
    }

    public function meetingsIndex()
    {
        $this->currentSupervisor();

        $meetings = ProjectMeeting::with(['project', 'student'])
            ->latest()
            ->paginate(10);

        return view('supervisor.meetings.index', compact('meetings'));
    }

    public function meetingsUpcoming()
    {
        $this->currentSupervisor();

        $meetings = ProjectMeeting::with(['project', 'student'])
            ->whereDate('meeting_date', '>=', now()->toDateString())
            ->where('status', 'scheduled')
            ->orderBy('meeting_date')
            ->orderBy('meeting_time')
            ->paginate(10);

        return view('supervisor.meetings.upcoming', compact('meetings'));
    }

    public function meetingsCompleted()
    {
        $this->currentSupervisor();

        $meetings = ProjectMeeting::with(['project', 'student'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('supervisor.meetings.completed', compact('meetings'));
    }

    public function meetingsCreate()
    {
        $this->currentSupervisor();

        $projects = Project::latest('project_id')->get();

        return view('supervisor.meetings.create', compact('projects'));
    }

    public function storeRequest(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'request_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
        ]);

        $requestItem = ProjectRequest::create([
            'project_id' => $project->project_id,
            'supervisor_id' => auth('admin')->id(),
            'student_id' => $project->student_id,
            'title' => $validated['title'],
            'request_type' => $validated['request_type'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'status' => 'pending',
        ]);

        if ($project->student) {
            $project->student->notify(new GeneralNotification([
                'title' => 'New Supervisor Request',
                'message' => 'A supervisor sent you a new request for your project: ' . $requestItem->title,
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-tasks',
            ]));
        }

        return redirect()
            ->route('supervisor.projects.show', $project->project_id)
            ->with('success', 'Request sent to student successfully.');
    }

    public function requestsIndex()
    {
        $this->currentSupervisor();

        $requests = ProjectRequest::with(['project', 'student', 'latestResponse'])
            ->latest()
            ->paginate(10);

        return view('supervisor.requests.index', compact('requests'));
    }

    public function requestsPending()
    {
        $this->currentSupervisor();

        $requests = ProjectRequest::with(['project', 'student', 'latestResponse'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('supervisor.requests.pending', compact('requests'));
    }

    public function requestsCompleted()
    {
        $this->currentSupervisor();

        $requests = ProjectRequest::with(['project', 'student', 'latestResponse'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('supervisor.requests.completed', compact('requests'));
    }

    public function updateRequestStatus(Request $request, ProjectRequest $requestItem)
    {
        $this->currentSupervisor();

        $validated = $request->validate([
            'status' => ['required', 'in:pending,completed,cancelled'],
        ]);

        $requestItem->update([
            'status' => $validated['status'],
        ]);

        if ($requestItem->student) {
            $statusText = ucfirst($validated['status']);

            $requestItem->student->notify(new GeneralNotification([
                'title' => 'Request Status Updated',
                'message' => "The request \"{$requestItem->title}\" status was changed to {$statusText}.",
                'url' => route('dashboard.academic', ['project' => $requestItem->project_id]),
                'icon' => 'fas fa-clipboard-check',
            ]));
        }

        return redirect()
            ->back()
            ->with('success', 'Request status updated successfully.');
    }

    public function storeEvaluation(Request $request, Project $project)
    {
        $user = $this->currentSupervisor();
        $this->authorizeProject($project);

        $validated = $request->validate([
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'decision' => ['required', 'in:approved,revision_requested,rejected'],
            'notes' => ['required', 'string'],
        ]);

        if (!$project->supervisor_id) {
            $project->update([
                'supervisor_id' => $user->id,
            ]);
        }

        ProjectReview::updateOrCreate(
            [
                'project_id' => $project->project_id,
                'supervisor_id' => $user->id,
            ],
            [
                'score' => $validated['score'] ?? null,
                'decision' => $validated['decision'],
                'notes' => $validated['notes'],
                'reviewed_at' => now(),
            ]
        );

        if ($project->student) {
            $project->student->notify(new GeneralNotification([
                'title' => 'Project Evaluation Submitted',
                'message' => 'A supervisor submitted or updated an evaluation for your project.',
                'url' => route('dashboard.academic', ['project' => $project->project_id]),
                'icon' => 'fas fa-star',
            ]));
        }

        return redirect()
            ->route('supervisor.projects.show', $project->project_id)
            ->with('success', 'Your evaluation has been saved successfully.');
    }
}