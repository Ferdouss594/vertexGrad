<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    // إنشاء مهمة جديدة
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'assigned_to' => 'nullable|exists:students,student_id',
            'due_date' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100'
        ]);

        $task = $project->tasks()->create($data);

        // تحديث تقدم المشروع تلقائياً
        $project->updateProgress();

        return redirect()->back()->with('success', 'Task added successfully!');
    }

    // تعديل مهمة
    public function update(Request $request, ProjectTask $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'assigned_to' => 'nullable|exists:students,student_id',
            'due_date' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100'
        ]);

        $task->update($data);

        // تحديث تقدم المشروع تلقائياً
        $task->project->updateProgress();

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    // حذف مهمة
    public function destroy(ProjectTask $task)
    {
        $project = $task->project;
        $task->delete();
        $project->updateProgress();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}
