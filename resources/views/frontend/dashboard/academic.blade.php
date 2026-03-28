@extends('frontend.layouts.app')

@section('content')
@php
    $btnPrimaryClass = 'inline-flex items-center justify-center rounded-2xl px-8 py-4 font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft';
    $btnSecondaryClass = 'inline-flex items-center justify-center rounded-2xl px-6 py-3 font-bold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300';

    $currentDecision = $currentProject->final_decision ?? null;

    $mediaUploadAllowedStatuses = ['approved', 'active', 'published'];
    $mediaUploadAllowedDecisions = ['published'];

    $decisionLabel = function ($decision) {
        return match ($decision) {
            'published' => 'Published',
            'revision_requested' => 'Revision Requested',
            'rejected' => 'Rejected',
            'pending' => 'Pending',
            null => null,
            default => ucfirst(str_replace('_', ' ', $decision)),
        };
    };
@endphp

<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative">
                <h1 class="text-4xl md:text-6xl font-black text-theme-text tracking-tight">
                    Welcome,
                    <span class="text-brand-accent">{{ explode(' ', $user->name)[0] }}</span>
                </h1>
                <p class="text-theme-muted mt-3 flex items-center tracking-[0.2em] uppercase text-xs font-bold">
                    <span class="w-10 h-[2px] bg-brand-accent mr-3"></span>
                    Researcher Identity: {{ $user->id + 5000 }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('project.submit.step1') }}" class="{{ $btnPrimaryClass }}">
                    <i class="fas fa-rocket mr-2"></i> Submit New Research
                </a>
            </div>
        </header>

        {{-- Announcements --}}
        @if(isset($announcements) && $announcements->count())
            @php
                $featuredAnnouncement = $announcements->first();
                $otherAnnouncements = $announcements->slice(1);
            @endphp

            <section id="announcementSection" class="mb-8">
                <div class="relative overflow-hidden rounded-[2rem] theme-panel shadow-brand-soft">
                    <div class="relative z-10 p-5 md:p-7">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:flex w-14 h-14 rounded-2xl border border-brand-accent bg-brand-accent-soft text-brand-accent items-center justify-center shrink-0">
                                <i class="fas fa-bullhorn text-lg"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-theme-surface-2 text-theme-muted border border-theme-border text-[11px] font-black uppercase tracking-[0.16em]">
                                        Announcement
                                    </span>

                                    @if($featuredAnnouncement->is_pinned)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-400/10 text-amber-500 border border-amber-400/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-thumbtack text-[10px]"></i>
                                            Pinned
                                        </span>
                                    @endif

                                    @if($featuredAnnouncement->expires_at)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-500/10 text-red-500 border border-red-500/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-hourglass-half text-[10px]"></i>
                                            Until {{ $featuredAnnouncement->expires_at->format('M d, Y • h:i A') }}
                                        </span>
                                    @endif
                                </div>

                                <h2 class="text-xl md:text-2xl font-black text-theme-text leading-tight mb-2">
                                    {{ $featuredAnnouncement->title }}
                                </h2>

                                <p class="text-theme-muted text-sm md:text-[15px] leading-7 max-w-4xl">
                                    {{ $featuredAnnouncement->body }}
                                </p>
                            </div>

                            <button type="button"
                                    onclick="dismissAnnouncements()"
                                    class="shrink-0 w-11 h-11 rounded-2xl border border-theme-border bg-theme-surface-2 hover:bg-brand-accent-soft text-theme-muted hover:text-theme-text transition flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        @if($otherAnnouncements->count())
                            <div class="mt-5 pt-5 border-t border-theme-border">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    @foreach($otherAnnouncements as $announcement)
                                        <div class="rounded-[1.5rem] border border-theme-border bg-theme-surface-2 transition p-4">
                                            <div class="flex items-start justify-between gap-3 mb-2">
                                                <h3 class="text-theme-text font-bold text-base leading-snug">
                                                    {{ $announcement->title }}
                                                </h3>

                                                @if($announcement->is_pinned)
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-400/10 text-amber-500 border border-amber-400/20 shrink-0">
                                                        <i class="fas fa-thumbtack text-[11px]"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-theme-muted text-sm leading-6">
                                                {{ \Illuminate\Support\Str::limit($announcement->body, 160) }}
                                            </p>

                                            @if($announcement->expires_at)
                                                <div class="mt-3 text-[11px] text-red-500 font-semibold">
                                                    Visible until {{ $announcement->expires_at->format('M d, Y • h:i A') }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        @if(session('success'))
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-green-500/40 bg-green-500/10 text-green-600">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-red-500/40 bg-red-500/10 text-red-600">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-red-500/40 bg-red-500/10 text-red-600">
                    <div class="font-bold mb-2">Please review the following:</div>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($currentProject && !$currentDecision && $currentProject->status === 'pending')
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-yellow-500/40 bg-yellow-500/10 text-yellow-700">
                    Your latest project <strong>"{{ $currentProject->name }}"</strong> has been submitted successfully and is currently <strong>pending manager review</strong>.
                </div>
            </div>
        @endif

        @if($currentProject && $currentDecision === 'rejected')
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-red-500/40 bg-red-500/10 text-red-600">
                    Your latest project <strong>"{{ $currentProject->name }}"</strong> was reviewed and rejected.
                </div>
            </div>
        @endif

        @if($currentProject && $currentDecision === 'revision_requested')
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-yellow-500/40 bg-yellow-500/10 text-yellow-700">
                    Your latest project <strong>"{{ $currentProject->name }}"</strong> requires revision based on the final decision.
                </div>
            </div>
        @endif

        @if($currentProject && $currentDecision === 'published')
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-green-500/40 bg-green-500/10 text-green-700">
                    Your latest project <strong>"{{ $currentProject->name }}"</strong> has been published successfully.
                </div>
            </div>
        @endif

        @if($currentProject && !$currentDecision && in_array($currentProject->status, $mediaUploadAllowedStatuses))
            <div class="max-w-6xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl border border-green-500/40 bg-green-500/10 text-green-700">
                    Your latest project <strong>"{{ $currentProject->name }}"</strong> has been approved. Please upload project images and videos to complete your project presentation.
                </div>
            </div>
        @endif

        @if($currentProject)
            {{-- HERO --}}
            <div class="relative overflow-hidden theme-panel rounded-[2.5rem] mb-10 transition-all">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col lg:flex-row justify-between gap-10">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-6 flex-wrap">
                                <span class="px-4 py-1.5 rounded-xl bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-[0.15em] border border-brand-accent">
                                    {{ $currentProject->category ?? 'Uncategorized' }}
                                </span>
                                <span class="text-theme-muted text-xs font-mono">REF: PRJ-{{ $currentProject->project_id + 1000 }}</span>
                            </div>

                            <h2 class="text-3xl md:text-5xl font-bold text-theme-text mb-8 leading-[1.1] tracking-tight">
                                {{ $currentProject->name }}
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                                <div class="theme-panel-soft p-4 rounded-2xl">
                                    <p class="text-theme-muted text-[10px] uppercase font-black mb-1 tracking-widest">Target Budget</p>
                                    <p class="text-2xl font-bold text-green-600">${{ number_format($currentProject->budget ?? 0) }}</p>
                                </div>

                                <div class="theme-panel-soft p-4 rounded-2xl">
                                    <p class="text-theme-muted text-[10px] uppercase font-black mb-1 tracking-widest">Submission Date</p>
                                    <p class="text-xl text-theme-text font-semibold">{{ $currentProject->created_at->format('M d, Y') }}</p>
                                </div>

                                <div class="theme-panel-soft p-4 rounded-2xl">
                                    <p class="text-theme-muted text-[10px] uppercase font-black mb-1 tracking-widest">Final Decision</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex h-2 w-2 relative">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-500 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                                        </div>
                                        <span class="text-lg font-bold text-theme-text italic">
                                            {{ $decisionLabel($currentDecision) ?? ($currentProject->status == 'pending' ? 'Reviewing' : ucfirst($currentProject->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Media Preview --}}
                            <div class="mt-10">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xs font-black text-theme-text uppercase tracking-[0.25em] flex items-center gap-3">
                                        <i class="fas fa-photo-video text-brand-accent"></i> Media Preview
                                    </h3>
                                    <div class="text-xs text-theme-muted font-mono">
                                        Images: {{ $currentImages->count() }} • Video: {{ $currentVideoUrl ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if($currentImages->count() > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach($currentImages->take(4) as $m)
                                            <a href="{{ $m->getUrl() }}" target="_blank"
                                               class="relative overflow-hidden rounded-2xl border border-theme-border bg-theme-surface-2 transition">
                                                <img src="{{ $m->getUrl() }}" class="w-full h-28 object-cover" alt="Project image">
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-5 rounded-2xl border border-theme-border bg-theme-surface-2 text-theme-muted text-sm">
                                        No images uploaded yet.
                                    </div>
                                @endif

                                @if($currentVideoUrl)
                                    <button type="button"
                                            onclick="openVideoModal('{{ $currentVideoUrl }}')"
                                            class="mt-4 w-full flex items-center justify-between p-5 bg-theme-surface-2 hover:bg-brand-accent-soft border border-theme-border rounded-2xl transition-all text-theme-text">
                                        <span class="font-bold text-xs uppercase tracking-wider">Play Video</span>
                                        <i class="fas fa-play text-brand-accent"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col justify-center gap-4 min-w-[260px]">
                            <a href="{{ route('frontend.projects.show', $currentProject->project_id) }}"
                               class="group/btn flex items-center justify-between p-5 bg-brand-accent text-white rounded-2xl transition-all hover:bg-brand-accent-strong">
                                <span class="font-black uppercase text-xs tracking-wider">Project Portfolio</span>
                                <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>

                            @if(in_array($currentDecision, $mediaUploadAllowedDecisions) || (!$currentDecision && in_array($currentProject->status, $mediaUploadAllowedStatuses)))
                                <button type="button"
                                        onclick="openUploadModal('{{ route('projects.media.upload', $currentProject->project_id) }}')"
                                        class="flex items-center justify-between p-5 bg-theme-surface-2 hover:bg-brand-accent-soft border border-theme-border rounded-2xl transition-all group text-theme-text">
                                    <span class="font-bold text-xs uppercase tracking-wider">Upload Project Media</span>
                                    <i class="fas fa-upload group-hover:-translate-y-1 transition-transform text-brand-accent"></i>
                                </button>
                            @else
                                <div class="flex items-center justify-between p-2 bg-theme-surface-2 border border-theme-border rounded-2xl text-theme-muted opacity-90">
                                    <div>
                                        <span class="block font-bold text-xs uppercase tracking-wider mb-1">Upload Locked</span>
                                        <span class="text-xs opacity-80">
                                            Project images and videos can be uploaded after the final decision allows it.
                                        </span>
                                    </div>
                                    <i class="fas fa-lock text-theme-muted"></i>
                                </div>
                            @endif

                            @php
                                $scanState = strtolower((string) ($currentProject->status ?? $currentProject->scanner_status ?? 'draft'));
                            @endphp

                            @if(in_array($scanState, ['draft', 'scan_failed', 'scan_requested', 'pending', 'rejected']))
                                <a href="http://127.0.0.1:8000/submit?platform_project_id={{ $currentProject->project_id }}&project_name={{ urlencode($currentProject->name) }}&student_name={{ urlencode($user->name) }}&student_email={{ urlencode($user->email) }}&language={{ urlencode($currentProject->primary_language ?? 'php') }}"
                                   class="flex items-center justify-between p-2 bg-blue-600 text-white rounded-2xl transition-all hover:bg-blue-700 group">
                                    <div>
                                        <span class="block font-black uppercase text-xs tracking-wider">
                                            Technical Scan
                                        </span>
                                        <span class="text-xs opacity-80">
                                            هل تريد فحص المشروع الآن؟
                                        </span>
                                    </div>
                                    <i class="fas fa-microscope group-hover:scale-110 transition-transform"></i>
                                </a>

                            @elseif(in_array($scanState, ['scan_completed', 'awaiting_manual_review', 'approved', 'published', 'active']))
                                <a href="http://127.0.0.1:8000/submit?platform_project_id={{ $currentProject->project_id }}&project_name={{ urlencode($currentProject->name) }}&student_name={{ urlencode($user->name) }}&student_email={{ urlencode($user->email) }}&language={{ urlencode($currentProject->language ?? $currentProject->primary_language ?? 'php') }}"
                                   class="flex items-center justify-between p-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition group">
                                    <div>
                                        <span class="block font-black uppercase text-xs tracking-wider">
                                            Technical Scan
                                        </span>
                                        <span class="text-xs opacity-80">
                                            تم تنفيذ الفحص، افتح مساحة الفحص
                                        </span>
                                    </div>
                                    <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="h-1.5 w-full bg-theme-surface-2">
                    <div class="h-full bg-brand-accent transition-all duration-1000" style="width: {{ $progress }}%"></div>
                </div>
            </div>

            {{-- REQUESTS --}}
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.2em] flex items-center gap-3">
                        <i class="fas fa-inbox text-brand-accent"></i> Supervisor Requests
                    </h2>
                    <div class="text-xs text-theme-muted font-mono">
                        Total: {{ $currentRequests->count() }}
                    </div>
                </div>

                @if($currentRequests->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($currentRequests as $requestItem)
                            @php
                                $status = strtolower($requestItem->status ?? 'pending');
                                $requestType = strtolower($requestItem->request_type ?? '');
                                $statusClasses = match($status) {
                                    'completed' => 'bg-green-500/10 text-green-600 border-green-500/20',
                                    'cancelled' => 'bg-red-500/10 text-red-600 border-red-500/20',
                                    default => 'bg-yellow-500/10 text-yellow-700 border-yellow-500/20',
                                };
                            @endphp

                            <div class="theme-panel rounded-[2rem] p-6">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div>
                                        <div class="text-theme-text text-lg font-black mb-1">{{ $requestItem->title }}</div>
                                        <div class="text-theme-muted text-xs uppercase tracking-[0.15em] font-bold">
                                            {{ ucfirst(str_replace('_', ' ', $requestItem->request_type)) }}
                                        </div>
                                    </div>

                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] border {{ $statusClasses }}">
                                        {{ ucfirst($requestItem->status) }}
                                    </span>
                                </div>

                                <div class="text-theme-muted text-sm leading-relaxed mb-4 whitespace-pre-line">
                                    {{ $requestItem->description ?: 'No additional details provided.' }}
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 text-sm">
                                    <div class="theme-panel-soft rounded-2xl p-4">
                                        <div class="text-theme-muted text-[10px] uppercase font-black tracking-widest mb-1">Supervisor</div>
                                        <div class="text-theme-text font-semibold">{{ $requestItem->supervisor->name ?? 'Supervisor' }}</div>
                                    </div>

                                    <div class="theme-panel-soft rounded-2xl p-4">
                                        <div class="text-theme-muted text-[10px] uppercase font-black tracking-widest mb-1">Due Date</div>
                                        <div class="text-theme-text font-semibold">
                                            {{ $requestItem->due_date ? \Carbon\Carbon::parse($requestItem->due_date)->format('M d, Y') : 'Not specified' }}
                                        </div>
                                    </div>
                                </div>

                                @if($requestItem->latestResponse)
                                    <div class="mb-5 p-4 rounded-2xl border border-green-500/20 bg-green-500/5">
                                        <div class="text-green-600 text-xs font-black uppercase tracking-[0.15em] mb-2">
                                            Your Latest Response Sent to Supervisor
                                        </div>

                                        @if($requestItem->latestResponse->response_text)
                                            <div class="text-theme-text text-sm mb-2 whitespace-pre-line">
                                                {{ $requestItem->latestResponse->response_text }}
                                            </div>
                                        @endif

                                        <div class="flex flex-wrap gap-3">
                                            @if($requestItem->latestResponse->response_link)
                                                <a href="{{ $requestItem->latestResponse->response_link }}" target="_blank"
                                                   class="text-brand-accent text-sm font-bold hover:underline">
                                                    Open Submitted Link
                                                </a>
                                            @endif

                                            @if($requestItem->latestResponse->attachment_path)
                                                <a href="{{ asset('storage/' . $requestItem->latestResponse->attachment_path) }}" target="_blank"
                                                   class="text-cyan-600 text-sm font-bold hover:underline">
                                                    Download Attachment
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-3">
                                    <button type="button"
                                            onclick="openRequestResponseModal(
                                                '{{ route('student.requests.respond', $requestItem->id) }}',
                                                @js($requestItem->title),
                                                @js($requestType)
                                            )"
                                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-brand-accent text-white font-black hover:bg-brand-accent-strong transition shadow-brand-soft">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ $requestItem->latestResponse ? 'Update & Send to Supervisor' : 'Send to Supervisor' }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="theme-panel rounded-[2rem] p-10 text-center text-theme-muted">
                        No supervisor requests for this project yet.
                    </div>
                @endif
            </section>

            {{-- MEETINGS --}}
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.2em] flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-brand-accent"></i> Meetings & Demo Sessions
                    </h2>
                    <div class="text-xs text-theme-muted font-mono">
                        Total: {{ $currentMeetings->count() }}
                    </div>
                </div>

                @if($currentMeetings->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($currentMeetings as $meeting)
                            @php
                                $meetingStatus = strtolower($meeting->status ?? 'scheduled');
                                $meetingStatusClasses = match($meetingStatus) {
                                    'completed' => 'bg-green-500/10 text-green-600 border-green-500/20',
                                    'cancelled' => 'bg-red-500/10 text-red-600 border-red-500/20',
                                    default => 'bg-yellow-500/10 text-yellow-700 border-yellow-500/20',
                                };
                            @endphp

                            <div class="theme-panel rounded-[2rem] p-6">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div>
                                        <div class="text-theme-text text-lg font-black mb-1">{{ $meeting->title }}</div>
                                        <div class="text-theme-muted text-xs uppercase tracking-[0.15em] font-bold">
                                            {{ ucfirst($meeting->meeting_type) }}
                                        </div>
                                    </div>

                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] border {{ $meetingStatusClasses }}">
                                        {{ ucfirst($meeting->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 text-sm">
                                    <div class="theme-panel-soft rounded-2xl p-4">
                                        <div class="text-theme-muted text-[10px] uppercase font-black tracking-widest mb-1">Meeting Date</div>
                                        <div class="text-theme-text font-semibold">
                                            {{ $meeting->meeting_date ? \Carbon\Carbon::parse($meeting->meeting_date)->format('M d, Y') : 'Not set' }}
                                        </div>
                                    </div>

                                    <div class="theme-panel-soft rounded-2xl p-4">
                                        <div class="text-theme-muted text-[10px] uppercase font-black tracking-widest mb-1">Meeting Time</div>
                                        <div class="text-theme-text font-semibold">
                                            {{ $meeting->meeting_time ? \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') : 'Not set' }}
                                        </div>
                                    </div>
                                </div>

                                @if($meeting->notes)
                                    <div class="mb-4 p-4 rounded-2xl border border-theme-border bg-theme-surface-2">
                                        <div class="text-theme-muted text-[10px] uppercase font-black tracking-widest mb-2">Meeting Notes</div>
                                        <div class="text-theme-text text-sm whitespace-pre-line">{{ $meeting->notes }}</div>
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-3">
                                    @if($meeting->meeting_link)
                                        <a href="{{ $meeting->meeting_link }}" target="_blank"
                                           class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-green-500 text-white font-black hover:bg-green-600 transition shadow-brand-soft">
                                            <i class="fas fa-video"></i>
                                            Join Meeting
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="theme-panel rounded-[2rem] p-10 text-center text-theme-muted">
                        No meetings scheduled for this project yet.
                    </div>
                @endif
            </section>

            {{-- Projects list --}}
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.2em] flex items-center gap-3">
                        <i class="fas fa-layer-group text-brand-accent"></i> Your Projects
                    </h2>
                    <div class="text-xs text-theme-muted font-mono">Total: {{ $projects->count() }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        @php
                            $thumb = $project->getFirstMediaUrl('images');
                            $imgCount = $project->getMedia('images')->count();
                            $hasVideo = (bool) $project->getFirstMediaUrl('videos');
                            $active = $project->project_id === $currentProject->project_id;
                            $projectDecision = $project->final_decision ?? null;
                        @endphp

                        <a href="{{ route('dashboard.academic', ['project' => $project->project_id]) }}"
                           class="block rounded-[2rem] overflow-hidden transition border {{ $active ? 'border-brand-accent shadow-brand-soft' : 'border-theme-border theme-panel hover:border-brand-accent/40' }}">
                            <div class="h-44 bg-theme-surface-2 relative">
                                @if($thumb)
                                    <img src="{{ $thumb }}" class="w-full h-full object-cover" alt="Project thumbnail">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-theme-muted">
                                        <div class="text-center">
                                            <i class="fas fa-image text-3xl mb-2"></i>
                                            <div class="text-xs uppercase tracking-[0.2em] font-black">No Image</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute top-4 left-4 flex gap-2">
                                    <span class="px-3 py-1 rounded-xl bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-[0.15em] border border-brand-accent">
                                        {{ $project->category ?? 'General' }}
                                    </span>
                                    @if($hasVideo)
                                        <span class="px-3 py-1 rounded-xl bg-theme-surface text-theme-text text-[10px] font-black uppercase tracking-[0.15em] border border-theme-border">
                                            Video
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-theme-muted text-xs font-mono">PRJ-{{ $project->project_id + 1000 }}</span>
                                    <span class="text-theme-muted text-xs font-mono">{{ $project->created_at?->format('M d, Y') }}</span>
                                </div>

                                <h3 class="text-theme-text text-lg font-black leading-tight mb-3">
                                    {{ \Illuminate\Support\Str::limit($project->name, 60) }}
                                </h3>

                                <div class="flex items-center justify-between text-sm">
                                    <div class="text-theme-muted">
                                        <span>Images:</span> <span class="font-bold text-theme-text">{{ $imgCount }}</span>
                                    </div>
                                    <div class="text-theme-muted">
                                        <span>Status:</span>
                                        <span class="font-bold text-theme-text">
                                            {{ $decisionLabel($projectDecision) ?? ($project->status === 'pending' ? 'Reviewing' : ucfirst($project->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @else
            <div class="theme-panel rounded-[3rem] p-20 text-center mb-12">
                <div class="w-24 h-24 bg-brand-accent-soft rounded-full flex items-center justify-center mx-auto mb-8 text-brand-accent text-4xl shadow-brand-soft">
                    <i class="fas fa-atom animate-spin-slow"></i>
                </div>
                <h2 class="text-3xl font-bold text-theme-text mb-3">No Active Research Found</h2>
                <p class="text-theme-muted mb-10 max-w-lg mx-auto leading-relaxed">
                    Your portal is empty. Take the first step by submitting your academic project.
                </p>
                <a href="{{ route('project.submit.step1') }}" class="{{ $btnPrimaryClass }}">
                    Start Submission
                </a>
            </div>
        @endif

    </div>
</div>

{{-- VIDEO MODAL --}}
<div id="videoModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeVideoModal()"></div>
    <div class="relative z-10 h-full overflow-y-auto">
        <div class="min-h-full flex items-start justify-center px-4 py-10">
            <div class="w-full max-w-4xl theme-panel rounded-[2rem] overflow-hidden">
                <div class="p-5 border-b border-theme-border flex items-center justify-between">
                    <div class="text-theme-text font-black">Project Video</div>
                    <button class="text-theme-muted hover:text-theme-text" onclick="closeVideoModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <video id="videoPlayer" class="w-full rounded-2xl border border-theme-border bg-black" controls playsinline>
                        <source id="videoSource" src="" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- UPLOAD MODAL --}}
<div id="uploadModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeUploadModal()"></div>
    <div class="relative z-10 h-full overflow-y-auto">
        <div class="min-h-full flex items-start justify-center px-4 py-10">
            <div class="w-full max-w-2xl theme-panel rounded-[2rem] overflow-hidden">
                <div class="p-5 border-b border-theme-border flex items-center justify-between">
                    <div>
                        <div class="text-theme-text font-black">Upload Data</div>
                        <div class="text-theme-muted text-xs font-mono">Add images/video to this project</div>
                    </div>
                    <button class="text-theme-muted hover:text-theme-text" onclick="closeUploadModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="uploadForm" class="p-6 space-y-5" method="POST" enctype="multipart/form-data" action="">
                    @csrf

                    <div class="theme-panel-soft p-4 rounded-2xl">
                        <label class="block text-sm font-bold text-theme-text mb-2">Add Photos (multiple)</label>
                        <input type="file" name="project_photos[]" multiple accept="image/*"
                               class="w-full p-2 rounded-lg border border-theme-border bg-theme-surface text-theme-text">
                    </div>

                    <div class="theme-panel-soft p-4 rounded-2xl">
                        <label class="block text-sm font-bold text-theme-text mb-2">Add Video (single)</label>
                        <input type="file" name="project_video" accept="video/*"
                               class="w-full p-2 rounded-lg border border-theme-border bg-theme-surface text-theme-text">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="closeUploadModal()"
                                class="px-6 py-3 rounded-2xl bg-theme-surface-2 hover:bg-brand-accent-soft border border-theme-border text-theme-text font-bold">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-brand-accent text-white font-black hover:bg-brand-accent-strong transition">
                            Upload Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- REQUEST RESPONSE MODAL --}}
<div id="requestResponseModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeRequestResponseModal()"></div>

    <div class="relative z-10 h-full overflow-y-auto">
        <div class="min-h-full flex items-start justify-center px-4 py-10">
            <div class="w-full max-w-3xl theme-panel rounded-[2rem] overflow-hidden">
                <div class="p-5 border-b border-theme-border flex items-center justify-between">
                    <div>
                        <div class="text-theme-text font-black" id="requestResponseModalTitle">Send Response to Supervisor</div>
                        <div class="text-theme-muted text-xs font-mono" id="requestResponseModalSubtitle">Submit your text, link, or attachment clearly to the supervisor</div>
                    </div>

                    <button class="text-theme-muted hover:text-theme-text" onclick="closeRequestResponseModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="requestResponseForm" class="p-6 space-y-5" method="POST" enctype="multipart/form-data" action="">
                    @csrf

                    <input type="hidden" name="response_text" id="generated_response_text">
                    <input type="hidden" name="response_link" id="generated_response_link">

                    <div id="normalRequestFields" class="space-y-5">
                        <div class="theme-panel-soft p-4 rounded-2xl">
                            <label class="block text-sm font-bold text-theme-text mb-2">Response Text</label>
                            <textarea id="normal_response_text" rows="5"
                                      class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                      placeholder="Write your response here..."></textarea>
                        </div>

                        <div class="theme-panel-soft p-4 rounded-2xl">
                            <label class="block text-sm font-bold text-theme-text mb-2">Response Link</label>
                            <input type="url" id="normal_response_link"
                                   class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                   placeholder="https://github.com/... or drive link ...">
                        </div>
                    </div>

                    <div id="systemVerificationFields" class="hidden space-y-5">
                        <div class="bg-brand-accent-soft border border-brand-accent rounded-2xl p-4 text-theme-text text-sm">
                            Please fill at least <strong>4 important items</strong>. The more details you provide, the easier it will be for the supervisor to verify your project technically.
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">Frontend URL</label>
                                <input type="url" id="sv_frontend_url" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="https://your-frontend.com">
                            </div>

                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">Backend URL</label>
                                <input type="url" id="sv_backend_url" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="https://your-backend.com">
                            </div>

                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">API Health / API Base URL</label>
                                <input type="url" id="sv_api_health_url" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="https://api.your-app.com/health">
                            </div>

                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">Admin Panel URL</label>
                                <input type="url" id="sv_admin_panel_url" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="https://your-app.com/admin">
                            </div>

                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">Demo Account</label>
                                <input type="text" id="sv_demo_account" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="demo@example.com">
                            </div>

                            <div class="theme-panel-soft p-4 rounded-2xl">
                                <label class="block text-sm font-bold text-theme-text mb-2">Demo Password</label>
                                <input type="text" id="sv_demo_password" class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text" placeholder="Password">
                            </div>
                        </div>

                        <div class="theme-panel-soft p-4 rounded-2xl">
                            <label class="block text-sm font-bold text-theme-text mb-2">Deployment Notes</label>
                            <textarea id="sv_deployment_notes" rows="5"
                                      class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                      placeholder="Hosting notes, ports, environments, setup steps, login instructions, or any important technical information..."></textarea>
                        </div>
                    </div>

                    <div class="theme-panel-soft p-4 rounded-2xl">
                        <label class="block text-sm font-bold text-theme-text mb-3">Attachment</label>

                        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                            <input type="file" name="attachment"
                                   class="flex-1 p-2 rounded-lg border border-theme-border bg-theme-surface text-theme-text">

                            <button type="button"
                                    onclick="submitRequestResponseForm()"
                                    class="px-6 py-3 rounded-xl bg-green-500 text-white font-black hover:bg-green-600 transition-all duration-300 flex items-center justify-center gap-2 shadow-brand-soft">
                                <i class="fas fa-paper-plane"></i>
                                Send Now
                            </button>
                        </div>

                        <div class="text-theme-muted text-xs mt-2">
                            Allowed: image, pdf, zip, docs, video, etc.
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="closeRequestResponseModal()"
                                class="px-6 py-3 rounded-2xl bg-theme-surface-2 hover:bg-brand-accent-soft border border-theme-border text-theme-text font-bold">
                            Cancel
                        </button>

                        <button type="button"
                                onclick="submitRequestResponseForm()"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand-accent text-white font-black hover:bg-brand-accent-strong transition shadow-brand-soft">
                            <i class="fas fa-paper-plane"></i>
                            Send to Supervisor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentRequestMode = 'normal';

    function dismissAnnouncements() {
        const section = document.getElementById('announcementSection');
        if (section) {
            section.style.transition = 'all 0.25s ease';
            section.style.opacity = '0';
            section.style.transform = 'translateY(-8px)';
            setTimeout(() => {
                section.remove();
            }, 250);
        }
    }

    function openVideoModal(url){
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('videoPlayer');
        const source = document.getElementById('videoSource');

        source.src = url;
        player.load();
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeVideoModal(){
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('videoPlayer');

        player.pause();
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openUploadModal(actionUrl){
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('uploadForm');

        form.action = actionUrl;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeUploadModal(){
        document.getElementById('uploadModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openRequestResponseModal(actionUrl, title, requestType){
        const modal = document.getElementById('requestResponseModal');
        const form = document.getElementById('requestResponseForm');
        const titleEl = document.getElementById('requestResponseModalTitle');
        const subtitleEl = document.getElementById('requestResponseModalSubtitle');

        form.action = actionUrl;

        const normalizedType = (requestType || '').toLowerCase();
        const isSystemVerification = normalizedType === 'system_verification' || normalizedType === 'verification';

        if (isSystemVerification) {
            currentRequestMode = 'system';
            titleEl.textContent = 'Complete System Verification Request: ' + title;
            subtitleEl.textContent = 'Provide the technical system details requested by the supervisor';
            document.getElementById('normalRequestFields').classList.add('hidden');
            document.getElementById('systemVerificationFields').classList.remove('hidden');
        } else {
            currentRequestMode = 'normal';
            titleEl.textContent = 'Send Response to Supervisor: ' + title;
            subtitleEl.textContent = 'Submit your text, link, or attachment clearly to the supervisor';
            document.getElementById('normalRequestFields').classList.remove('hidden');
            document.getElementById('systemVerificationFields').classList.add('hidden');
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeRequestResponseModal(){
        document.getElementById('requestResponseModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function submitRequestResponseForm() {
        const form = document.getElementById('requestResponseForm');
        const generatedText = document.getElementById('generated_response_text');
        const generatedLink = document.getElementById('generated_response_link');

        if (currentRequestMode === 'system') {
            const frontendUrl = document.getElementById('sv_frontend_url').value.trim();
            const backendUrl = document.getElementById('sv_backend_url').value.trim();
            const apiHealthUrl = document.getElementById('sv_api_health_url').value.trim();
            const adminPanelUrl = document.getElementById('sv_admin_panel_url').value.trim();
            const demoAccount = document.getElementById('sv_demo_account').value.trim();
            const demoPassword = document.getElementById('sv_demo_password').value.trim();
            const deploymentNotes = document.getElementById('sv_deployment_notes').value.trim();

            const importantFields = [
                frontendUrl,
                backendUrl,
                apiHealthUrl,
                adminPanelUrl,
                demoAccount,
                demoPassword
            ];

            const filledCount = importantFields.filter(v => v !== '').length;

            if (filledCount < 4) {
                alert('Please fill at least 4 important system verification fields before sending.');
                return;
            }

            generatedText.value =
`System Verification Response

Frontend URL: ${frontendUrl || 'Not provided'}
Backend URL: ${backendUrl || 'Not provided'}
API Health / API Base URL: ${apiHealthUrl || 'Not provided'}
Admin Panel URL: ${adminPanelUrl || 'Not provided'}
Demo Account: ${demoAccount || 'Not provided'}
Demo Password: ${demoPassword || 'Not provided'}

Deployment Notes:
${deploymentNotes || 'No deployment notes provided.'}`;

            generatedLink.value = frontendUrl || backendUrl || apiHealthUrl || adminPanelUrl || '';
        } else {
            const normalText = document.getElementById('normal_response_text').value.trim();
            const normalLink = document.getElementById('normal_response_link').value.trim();

            generatedText.value = normalText;
            generatedLink.value = normalLink;
        }

        form.submit();
    }
</script>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>
@endsection