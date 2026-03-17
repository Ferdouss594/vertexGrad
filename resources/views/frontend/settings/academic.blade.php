@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background: linear-gradient(135deg, {{ $darkBg }} 0%, #0f172a 100%);">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <header class="mb-10 rounded-2xl p-8 border border-light/20 shadow-2xl"
                style="background: linear-gradient(135deg, rgba(30,41,59,.95), rgba(15,23,42,.95));">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold text-light mb-2">
                        👤 Academic Dashboard
                    </h1>
                    <p class="text-lg text-primary">
                        Track your projects, scan results, and account settings in one professional workspace.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 min-w-[260px]">
                    <div class="rounded-xl p-4 text-center border border-primary/20 bg-dark/60">
                        <div class="text-2xl font-extrabold text-light">{{ isset($projects) ? $projects->count() : 0 }}</div>
                        <div class="text-sm text-light/70 mt-1">Projects</div>
                    </div>
                    <div class="rounded-xl p-4 text-center border border-primary/20 bg-dark/60">
                        <div class="text-2xl font-extrabold text-light">
                            {{ isset($projects) ? $projects->where('status', 'awaiting_manual_review')->count() : 0 }}
                        </div>
                        <div class="text-sm text-light/70 mt-1">Awaiting Approval</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-6 py-4 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">✅</div>
                    <div>
                        <h3 class="text-lg font-bold text-green-300 mb-1">Success</h3>
                        <p class="text-sm text-green-100/90 leading-6">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-6 py-4 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">⚠️</div>
                    <div>
                        <h3 class="text-lg font-bold text-red-300 mb-1">Notice</h3>
                        <p class="text-sm text-red-100/90 leading-6">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Global Review Alert --}}
        @if(isset($projects) && $projects->where('status', 'awaiting_manual_review')->count())
            <div class="mb-8 rounded-2xl border border-yellow-400/30 bg-yellow-500/10 px-6 py-5 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="text-2xl">⏳</div>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-300 mb-1">
                            Project Under Review
                        </h3>
                        <p class="text-sm text-yellow-100/90 leading-7">
                            Your project has been successfully scanned technically. It is now under technical and administrative review.
                            We will notify you as soon as the approval decision is made.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Projects Section --}}
        @if(isset($projects) && $projects->count())
            <div class="mb-10">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-bold text-light">📂 Your Projects</h2>
                    <span class="text-sm text-light/60">Latest synced projects from the platform</span>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    @foreach($projects as $project)
                        @php
                            $report = $project->scan_report;

                            if (is_string($report)) {
                                $decoded = json_decode($report, true);
                                $report = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
                            }

                            $summary = data_get($report, 'summary', []);
                            $highlights = data_get($report, 'highlights', []);
                            $recommendations = data_get($report, 'recommendations', []);

                            $statusText = match($project->status) {
                                'awaiting_manual_review' => 'Awaiting Approval',
                                'scan_requested' => 'Scan Requested',
                                'scan_failed' => 'Scan Failed',
                                'approved' => 'Approved',
                                'published' => 'Published',
                                'completed' => 'Completed',
                                default => ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')),
                            };

                            $statusColor = match($project->status) {
                                'awaiting_manual_review' => 'text-yellow-400 bg-yellow-500/10 border-yellow-400/30',
                                'approved', 'published', 'completed' => 'text-green-400 bg-green-500/10 border-green-400/30',
                                'scan_failed', 'rejected' => 'text-red-400 bg-red-500/10 border-red-400/30',
                                default => 'text-blue-400 bg-blue-500/10 border-blue-400/30',
                            };

                            $scanStatusText = match($project->scanner_status) {
                                'completed' => 'Completed',
                                'pending' => 'Pending',
                                'failed' => 'Failed',
                                default => ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'Not Scanned')),
                            };

                            $scanStatusColor = match($project->scanner_status) {
                                'completed' => 'text-green-400 bg-green-500/10 border-green-400/30',
                                'pending' => 'text-orange-400 bg-orange-500/10 border-orange-400/30',
                                'failed' => 'text-red-400 bg-red-500/10 border-red-400/30',
                                default => 'text-slate-300 bg-slate-500/10 border-slate-400/30',
                            };

                            $risk = $project->risk_level ?? data_get($report, 'scan.risk_level');
                            $riskColor = match(strtolower($risk ?? '')) {
                                'low' => 'text-green-400 bg-green-500/10 border-green-400/30',
                                'medium' => 'text-yellow-400 bg-yellow-500/10 border-yellow-400/30',
                                'high' => 'text-red-400 bg-red-500/10 border-red-400/30',
                                default => 'text-slate-300 bg-slate-500/10 border-slate-400/30',
                            };
                        @endphp

                        <div class="rounded-2xl border border-light/10 shadow-xl overflow-hidden"
                             style="background: linear-gradient(135deg, rgba(30,41,59,.96), rgba(15,23,42,.96));">

                            <div class="p-6 border-b border-light/10">
                                <div class="flex justify-between items-start gap-4 flex-wrap">
                                    <div>
                                        <h3 class="text-2xl font-bold text-light mb-2">
                                            {{ $project->name }}
                                        </h3>
                                        <p class="text-light/60 text-sm">
                                            {{ $project->category ?? 'General Category' }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $scanStatusColor }}">
                                            Scan: {{ $scanStatusText }}
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $riskColor }}">
                                            Risk: {{ $risk ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">

                                {{-- Awaiting Approval Notice --}}
                                @if($project->status === 'awaiting_manual_review')
                                    <div class="mb-6 rounded-xl border border-yellow-400/30 bg-yellow-500/10 px-4 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="text-xl">⏳</div>
                                            <div>
                                                <h4 class="text-sm font-bold text-yellow-300 mb-1">
                                                    Awaiting Final Approval
                                                </h4>
                                                <p class="text-sm text-yellow-100/90 leading-6">
                                                    This project has been scanned technically and is now under technical and administrative review.
                                                    You will be notified once the approval decision is made.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Approved Notice --}}
                                @if(in_array($project->status, ['approved', 'published', 'completed']))
                                    <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 px-4 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="text-xl">🎉</div>
                                            <div>
                                                <h4 class="text-sm font-bold text-green-300 mb-1">
                                                    Project Approved
                                                </h4>
                                                <p class="text-sm text-green-100/90 leading-6">
                                                    Your project has been approved successfully. You can now upload supporting media files such as project images and videos.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <div class="rounded-xl p-4 bg-dark/50 border border-light/10">
                                        <div class="text-sm text-light/60">Scan Score</div>
                                        <div class="text-2xl font-extrabold text-primary mt-1">
                                            {{ $project->scan_score !== null ? number_format($project->scan_score, 0) : '-' }}
                                        </div>
                                    </div>

                                    <div class="rounded-xl p-4 bg-dark/50 border border-light/10">
                                        <div class="text-sm text-light/60">Scanner ID</div>
                                        <div class="text-lg font-bold text-light mt-1">
                                            {{ $project->scanner_project_id ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="rounded-xl p-4 bg-dark/50 border border-light/10">
                                        <div class="text-sm text-light/60">Scanned At</div>
                                        <div class="text-sm font-semibold text-light mt-1">
                                            {{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}
                                        </div>
                                    </div>

                                    <div class="rounded-xl p-4 bg-dark/50 border border-light/10">
                                        <div class="text-sm text-light/60">Budget</div>
                                        <div class="text-lg font-bold text-light mt-1">
                                            {{ $project->budget ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="rounded-xl p-5 bg-dark/40 border border-light/10">
                                        <h4 class="text-lg font-bold text-primary mb-4">Scan Summary</h4>
                                        <div class="space-y-3 text-sm">
                                            <div class="flex justify-between text-light/80">
                                                <span>Total Files</span>
                                                <span class="font-semibold">{{ data_get($summary, 'total_files', '-') }}</span>
                                            </div>
                                            <div class="flex justify-between text-light/80">
                                                <span>Total Issues</span>
                                                <span class="font-semibold">{{ data_get($summary, 'issues_total', '-') }}</span>
                                            </div>
                                            <div class="flex justify-between text-red-400">
                                                <span>Critical</span>
                                                <span class="font-semibold">{{ data_get($summary, 'critical', '-') }}</span>
                                            </div>
                                            <div class="flex justify-between text-orange-400">
                                                <span>High</span>
                                                <span class="font-semibold">{{ data_get($summary, 'high', '-') }}</span>
                                            </div>
                                            <div class="flex justify-between text-yellow-400">
                                                <span>Medium</span>
                                                <span class="font-semibold">{{ data_get($summary, 'medium', '-') }}</span>
                                            </div>
                                            <div class="flex justify-between text-green-400">
                                                <span>Low</span>
                                                <span class="font-semibold">{{ data_get($summary, 'low', '-') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-xl p-5 bg-dark/40 border border-light/10">
                                        <h4 class="text-lg font-bold text-primary mb-4">Project Status</h4>
                                        <div class="space-y-3 text-sm text-light/80">
                                            <div class="flex justify-between">
                                                <span>Main Status</span>
                                                <span class="font-semibold">{{ $statusText }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Scan Status</span>
                                                <span class="font-semibold">{{ $scanStatusText }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Approval Stage</span>
                                                <span class="font-semibold">
                                                    {{ $project->status === 'awaiting_manual_review' ? 'Awaiting Approval' : ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Created</span>
                                                <span class="font-semibold">{{ optional($project->created_at)->format('d/m/Y') ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(!empty($highlights))
                                    <div class="mt-6 rounded-xl p-5 bg-dark/40 border border-light/10">
                                        <h4 class="text-lg font-bold text-primary mb-3">Highlights</h4>
                                        <ul class="space-y-2 text-light/80 text-sm">
                                            @foreach($highlights as $highlight)
                                                <li>• {{ $highlight }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(!empty($recommendations))
                                    <div class="mt-6 rounded-xl p-5 bg-dark/40 border border-light/10">
                                        <h4 class="text-lg font-bold text-primary mb-3">Recommendations</h4>
                                        <ul class="space-y-2 text-light/80 text-sm">
                                            @foreach($recommendations as $recommendation)
                                                <li>• {{ $recommendation }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Media Upload Action --}}
                                <div class="mt-6 flex flex-wrap gap-3">
                                    @if(in_array($project->status, ['approved', 'published', 'completed']))
                                        <a href="{{ route('projects.media.form', $project) }}"
                                           class="inline-flex items-center px-4 py-2 rounded-xl font-semibold text-white border border-primary/20 shadow-lg"
                                           style="background: linear-gradient(135deg, {{ $primaryColor }}, #0ea5e9);">
                                            <i class="fas fa-images mr-2"></i>
                                            Add Media Files
                                        </a>
                                    @else
                                        <button type="button"
                                                disabled
                                                class="inline-flex items-center px-4 py-2 rounded-xl font-semibold text-slate-400 border border-slate-600 cursor-not-allowed bg-slate-800/60">
                                            <i class="fas fa-images mr-2"></i>
                                            Add Media Files
                                        </button>
                                    @endif
                                </div>

                                @if(!in_array($project->status, ['approved', 'published', 'completed']))
                                    <p class="mt-2 text-sm text-yellow-400">
                                        Media upload will be available after the project is approved.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Settings Form --}}
        <form action="/settings/academic/update" method="POST" class="space-y-8">
            @csrf
            
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Personal & Contact Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-light/80 mb-2">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="Dr. Elias Thorne" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="academic_title" class="block text-sm font-medium text-light/80 mb-2">Academic Title</label>
                        <input type="text" id="academic_title" name="academic_title" value="Principal Investigator" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address (Login)</label>
                        <input type="email" id="email" name="email" value="thorne@uni.edu" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-light/80 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="+1-555-123-4567" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Institutional Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="institution" class="block text-sm font-medium text-light/80 mb-2">Institution Name</label>
                        <input type="text" id="institution" name="institution" value="Wageningen University & Research" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="department" class="block text-sm font-medium text-light/80 mb-2">Department / Lab</label>
                        <input type="text" id="department" name="department" value="Robotics and Sensing Lab" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Notification Preferences</h2>
                <div class="space-y-3">
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="notif_status_change" checked 
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Email me when my project status changes.</span>
                    </label>
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="notif_investor_interest"
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Email me when an investor begins due diligence on my project.</span>
                    </label>
                </div>
            </div>

            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Security</h2>
                <a href="/settings/password/change" class="text-primary hover:underline font-medium">
                    Change Password <i class="fas fa-lock ml-2"></i>
                </a>
            </div>

            <div class="pt-4 text-right">
                <button type="submit" class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save All Changes
                </button>
            </div>
        </form>

    </div>
</div>
@endsection