<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

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
}