@extends('layouts.app')
@section('title','Project Details')

@section('content')
@php
    /** @var \App\Models\Project $project */
@endphp

<div class="container">

    {{-- Project Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title mb-2">{{ $project->name }}</h1>
            <p class="card-text text-muted">{{ $project->description ?? '-' }}</p>

            <div class="row g-3 mt-2">
                <div class="col-md-3"><strong>Status:</strong> {{ $project->status }}</div>
                <div class="col-md-3"><strong>Progress:</strong> {{ $project->progress }}%</div>
                <div class="col-md-3"><strong>Category:</strong> {{ $project->category ?? '-' }}</div>
                <div class="col-md-3"><strong>Budget:</strong> {{ $project->budget ?? '-' }}</div>
                <div class="col-md-3"><strong>Priority:</strong> {{ $project->priority ?? '-' }}</div>
                <div class="col-md-3"><strong>Start:</strong> {{ optional($project->start_date)->format('d/m/Y') ?? '-' }}</div>
                <div class="col-md-3"><strong>End:</strong> {{ optional($project->end_date)->format('d/m/Y') ?? '-' }}</div>
            </div>

            <hr class="my-3">

            {{-- ✅ Null-safe relations (this fixes your screenshot errors) --}}
            <div class="row g-3">
                <div class="col-md-3"><strong>Supervisor:</strong> {{ $project->supervisor?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Student:</strong> {{ $project->student?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Manager:</strong> {{ $project->manager?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Investor:</strong> {{ $project->investor?->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- ✅ Spatie Media (Compatible with student flow) --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Project Media (Spatie)</h3>
        </div>
        <div class="card-body">
            @php
                $images = method_exists($project, 'getMedia') ? $project->getMedia('images') : collect();
                $videoUrl = method_exists($project, 'getFirstMediaUrl') ? $project->getFirstMediaUrl('videos') : null;
            @endphp

            <h5 class="mb-3">Images ({{ $images->count() }})</h5>

            @if($images->count())
                <div class="row">
                    @foreach($images as $m)
                        <div class="col-md-3 mb-3">
                            <a href="{{ $m->getUrl() }}" target="_blank" class="d-block">
                                <img src="{{ $m->getUrl() }}" class="img-fluid rounded border" alt="Project image">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No images uploaded.</p>
            @endif

            <hr>

            <h5 class="mb-3">Video</h5>
            @if($videoUrl)
                <video class="w-100 rounded border" controls style="max-height:420px;">
                    <source src="{{ $videoUrl }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <p class="text-muted">No video uploaded.</p>
            @endif
        </div>
    </div>

    {{-- Optional: Legacy ProjectFile system (if you still use it somewhere) --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Legacy Files (ProjectFile table)</h3>
        </div>
        <div class="card-body">
            @if(isset($project->files) && $project->files->count())
                <div class="row">
                    @foreach($project->files as $file)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="small text-muted mb-2">{{ $file->file_type ?? 'file' }}</div>
                                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                                        Open file
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No legacy files found.</p>
            @endif
        </div>
    </div>
<!-- أضيفي هذا الكود في صفحة المشروع -->
@php
use Illuminate\Support\Facades\DB;
$scanLink = DB::table('project_scans')
    ->where('main_project_id', $project->id)
    ->first();
@endphp

@if($scanLink)
    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h5>🔍 نتائج فحص المشروع</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>رقم المشروع في منصة الفحص:</strong> {{ $scanLink->scanner_project_id }}</p>
                    <p><strong>حالة الربط:</strong> 
                        @if($scanLink->status == 'pending')
                            <span class="badge badge-warning">في الانتظار</span>
                        @elseif($scanLink->status == 'imported')
                            <span class="badge badge-success">تم الاستيراد</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-left">
                    <a href="http://localhost/phpmyadmin/index.php?route=/sql&db=vertexgrad_scanner&table=scan_results&sql_query=SELECT%20*%20FROM%20`scan_results`%20WHERE%20`project_id`%20%3D%20{{ $scanLink->scanner_project_id }}" 
                       class="btn btn-primary" target="_blank">
                        <i class="bi bi-eye"></i> عرض نتائج الفحص
                    </a>
                    
                    <a href="{{ route('projects.scan-results', $project->id) }}" 
                       class="btn btn-info" target="_blank">
                        <i class="bi bi-file-text"></i> تفاصيل الفحص
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card mt-3">
        <div class="card-header bg-warning">
            <h5>🔗 ربط مع منصة الفحص</h5>
        </div>
        <div class="card-body">
            <p>هذا المشروع غير مرتبط بمنصة الفحص بعد</p>
            <a href="{{ route('admin.link-projects') }}" class="btn btn-success">
                <i class="bi bi-link"></i> ربط المشروع الآن
            </a>
        </div>
    </div>
@endif
</div>
@endsection