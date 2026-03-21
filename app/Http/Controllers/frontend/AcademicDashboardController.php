<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectRequest;
use App\Models\ProjectRequestResponse;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

class AcademicDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Student', 403);

        $projects = Project::where('student_id', $user->id)
            ->with('media')
            ->latest('project_id')
            ->get();

        $selectedId = (int) $request->query('project', 0);
        $currentProject = $selectedId ? $projects->firstWhere('project_id', $selectedId) : null;

        if (!$currentProject) {
            $currentProject = $projects->first();
        }

        $progress = 20;
        if ($currentProject) {
            if ($currentProject->status === 'active') {
                $progress = 60;
            } elseif ($currentProject->status === 'completed') {
                $progress = 100;
            } elseif ($currentProject->status === 'rejected') {
                $progress = 0;
            } elseif ($currentProject->status === 'pending') {
                $progress = 35;
            }
        }

        $currentImages = collect();
        $currentVideoUrl = null;
        $currentRequests = collect();
        $currentMeetings = collect();

        if ($currentProject) {
            $currentImages = method_exists($currentProject, 'getMedia')
                ? $currentProject->getMedia('images')
                : collect();

            $currentVideoUrl = method_exists($currentProject, 'getFirstMediaUrl')
                ? $currentProject->getFirstMediaUrl('videos')
                : null;

            $currentRequests = method_exists($currentProject, 'requests')
                ? $currentProject->requests()
                    ->with(['supervisor', 'latestResponse'])
                    ->latest()
                    ->get()
                : collect();

            $currentMeetings = method_exists($currentProject, 'meetings')
                ? $currentProject->meetings()
                    ->latest('meeting_date')
                    ->get()
                : collect();
        }

        return view('frontend.dashboard.academic', compact(
            'user',
            'projects',
            'currentProject',
            'progress',
            'currentImages',
            'currentVideoUrl',
            'currentRequests',
            'currentMeetings'
        ));
    }

    public function respondToRequest(Request $request, ProjectRequest $requestItem)
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Student', 403);
        abort_unless((int) $requestItem->student_id === (int) $user->id, 403);

        $validated = $request->validate([
            'response_text' => ['nullable', 'string'],
            'response_link' => ['nullable', 'url', 'max:500'],
            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,zip,mp4,mov,doc,docx,ppt,pptx,xls,xlsx',
                'max:20480',
            ],
        ]);

        if (
            empty($validated['response_text']) &&
            empty($validated['response_link']) &&
            !$request->hasFile('attachment')
        ) {
            return redirect()
                ->back()
                ->with('error', 'Please provide a response text, a link, or an attachment.');
        }

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('project-request-responses', 'public');
        }

        ProjectRequestResponse::create([
            'project_request_id' => $requestItem->id,
            'student_id' => $user->id,
            'response_text' => $validated['response_text'] ?? null,
            'response_link' => $validated['response_link'] ?? null,
            'attachment_path' => $attachmentPath,
            'submitted_at' => now(),
        ]);

        $requestItem->update([
            'status' => 'completed',
        ]);

        if ($requestItem->supervisor) {
            $isSystemVerification = strtolower($requestItem->request_type ?? '') === 'system_verification';

            $requestItem->supervisor->notify(new GeneralNotification([
                'title' => $isSystemVerification
                    ? 'System Verification Submitted'
                    : 'Student Response Submitted',
                'message' => $isSystemVerification
                    ? 'The student submitted the system verification details for the project.'
                    : 'The student submitted a response to your request: ' . $requestItem->title,
                'url' => route('supervisor.projects.show', $requestItem->project_id),
                'icon' => $isSystemVerification ? 'fas fa-server' : 'fas fa-reply',
            ]));
        }

        return redirect()
            ->back()
            ->with('success', 'Your response has been submitted successfully.');
    }
}