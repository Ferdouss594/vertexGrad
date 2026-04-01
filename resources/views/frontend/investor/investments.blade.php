@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="{{ config('design.classes.container') }}">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-theme-text">
                    {{ __('frontend.investments.my') }} <span class="text-brand-accent">{{ __('frontend.investments.investments') }}</span>
                </h1>
                <p class="text-theme-muted mt-2">
                    {{ __('frontend.investments.subtitle') }}
                </p>
            </div>
        </div>

        <div class="theme-panel rounded-3xl overflow-hidden shadow-brand-soft">
            @if($projects->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-theme-surface-2 border-b border-theme-border">
                            <tr>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.project') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.student') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.status') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.amount') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.date') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($projects as $project)
                                @php
                                    $status = strtolower($project->pivot->status ?? 'interested');
                                    $statusClasses = match($status) {
                                        'approved' => 'bg-green-500/10 text-green-600 border-green-500/20',
                                        'requested' => 'bg-yellow-500/10 text-yellow-700 border-yellow-500/20',
                                        'rejected' => 'bg-red-500/10 text-red-600 border-red-500/20',
                                        default => 'bg-brand-accent-soft text-brand-accent border-brand-accent/20',
                                    };
                                @endphp

                                <tr class="border-b border-theme-border last:border-b-0">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('frontend.projects.show', $project) }}"
                                           class="font-bold text-theme-text hover:text-brand-accent transition">
                                            {{ $project->name }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-5 text-theme-muted">
                                        {{ $project->student->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-[11px] font-black uppercase tracking-widest border {{ $statusClasses }}">
                                            {{ ucfirst($project->pivot->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 font-bold text-theme-text">
                                        ${{ number_format($project->pivot->amount ?? 0) }}
                                    </td>

                                    <td class="px-6 py-5 text-theme-muted">
                                        {{ $project->pivot->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-brand-accent-soft text-brand-accent flex items-center justify-center mb-4">
                        <i class="fas fa-briefcase text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-theme-text mb-2">{{ __('frontend.investments.no_investments_yet') }}</h3>
                    <p class="text-theme-muted mb-6">{{ __('frontend.investments.no_investments_text') }}</p>
                    <a href="{{ route('frontend.projects.index') }}"
                       class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                        {{ __('frontend.investments.explore_projects') }}
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection