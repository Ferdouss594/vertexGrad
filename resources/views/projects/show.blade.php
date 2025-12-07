@extends('layouts.app')
@section('title','Project Details')
@section('content')
<div class="container">
    <h1>{{ $project->name }}</h1>
    <p>{{ $project->description }}</p>
    <p>Status: {{ $project->status }}</p>
    <p>Progress: {{ $project->progress }}%</p>

    <h3>Tasks</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->assignedStudent->name ?? '-' }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->progress }}%</td>
                    <td>
                        <!-- يمكن إضافة أزرار تعديل وحذف هنا -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- نموذج إضافة مهمة -->
    <form action="{{ route('projects.tasks.store', $project->project_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="title" placeholder="Task Title" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <textarea name="description" placeholder="Description" class="form-control"></textarea>
        </div>
        <div class="form-group mt-2">
            <select name="status" class="form-control">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <input type="number" name="progress" placeholder="Progress %" class="form-control" min="0" max="100">
        </div>
        <button class="btn btn-success mt-2">Add Task</button>
    </form>
</div>
@endsection
