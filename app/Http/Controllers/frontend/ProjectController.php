<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['media', 'student'])
            ->where('status', '!=', 'Draft');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }

        $projects = $query->latest()->paginate(12)->appends($request->all());

        return view('frontend.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['media', 'student']);

        // Student can only view his project if you want strict rule:
        if (auth()->check() && auth()->user()->role === 'Student' && $project->student_id !== auth()->id()) {
            abort(403);
        }

        return view('frontend.projects.show', compact('project'));
    }

    public function mediaForm(Project $project)
    {
        // Security: ensure the logged-in student owns the project
        if ($project->student_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.projects.media_upload', compact('project'));
    }

    public function mediaUpload(Request $request, Project $project)
    {
        if ($project->student_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'project_photos'   => 'nullable|array',
            'project_photos.*' => 'image|max:5120',
            'project_video'    => 'nullable|mimes:mp4,mov,ogg,qt|max:51200',
        ]);

        // Photos (multiple)
        if ($request->hasFile('project_photos')) {
            foreach ($request->file('project_photos') as $img) {
                $project->addMedia($img)->toMediaCollection('images');
            }
        }

        // Video (single)
        if ($request->hasFile('project_video')) {
            $project->addMedia($request->file('project_video'))->toMediaCollection('videos');
        }

        return back()->with('success', 'Media uploaded successfully!');
    }
}