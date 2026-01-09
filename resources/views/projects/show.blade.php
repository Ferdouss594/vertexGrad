@extends('layouts.app')
@section('title','Project Details')
@section('content')
<div class="container">

    <!-- معلومات المشروع الأساسية -->
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">{{ $project->name }}</h1>
            <p class="card-text">{{ $project->description ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $project->status }}</p>
            <p><strong>Progress:</strong> {{ $project->progress }}%</p>
            <p><strong>Category:</strong> {{ $project->category ?? '-' }}</p>
            <p><strong>Budget:</strong> {{ $project->budget ?? '-' }}</p>
            <p><strong>Priority:</strong> {{ $project->priority ?? '-' }}</p>
            <p><strong>Start Date:</strong> {{ $project->start_date?->format('d/m/Y') ?? '-' }}</p>
            <p><strong>End Date:</strong> {{ $project->end_date?->format('d/m/Y') ?? '-' }}</p>
            <p><strong>Supervisor:</strong> {{ $project->supervisor->name ?? '-' }}</p>
            <p><strong>Student:</strong> {{ $project->student->name ?? '-' }}</p>
            <p><strong>Manager:</strong> {{ $project->manager->name ?? '-' }}</p>
            <p><strong>Investor:</strong> {{ $project->investor->name ?? '-' }}</p>
        </div>
    </div>

    <!-- عرض الملفات المرفوعة -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Project Files</h3>
        </div>
        <div class="card-body">
            @if($project->files->count())
                <div class="row">
                    @foreach($project->files as $file)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                @if(in_array($file->file_type, ['images']))
                                    <img src="{{ asset('storage/'.$file->path) }}" class="card-img-top" alt="{{ $file->file_name }}">
                                @elseif(in_array($file->file_type, ['videos']))
                                    <video class="card-img-top" controls>
                                        <source src="{{ asset('storage/'.$file->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif(in_array($file->file_type, ['pdf', 'ppts']))
                                    <div class="card-body text-center">
                                        <a href="{{ asset('storage/'.$file->path) }}" target="_blank">
                                            <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                                            <p>{{ $file->file_name }}</p>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No files uploaded for this project.</p>
            @endif
        </div>
    </div>

   
@endsection
