@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(isset($projects) && $projects->count())
            <div class="mb-10">
                <header class="mb-10 rounded-2xl p-8 border border-theme-border theme-panel shadow-brand-soft">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <h1 class="text-4xl font-extrabold text-theme-text mb-2">
                                {{ __('frontend.academic.dashboard_title_before') }}
                                <span class="text-brand-accent">{{ __('frontend.academic.dashboard_title_highlight') }}</span>
                            </h1>
                            <p class="text-lg text-theme-muted">
                                {{ __('frontend.academic.dashboard_subtitle') }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 min-w-[260px]">
                            <div class="rounded-xl p-4 text-center border border-theme-border bg-theme-surface-2">
                                <div class="text-2xl font-extrabold text-theme-text">
                                    {{ $projects->count() }}
                                </div>
                                <div class="text-sm text-theme-muted mt-1">
                                    {{ __('frontend.academic.projects') }}
                                </div>
                            </div>
                            <div class="rounded-xl p-4 text-center border border-theme-border bg-theme-surface-2">
                                <div class="text-2xl font-extrabold text-theme-text">
                                    {{ $projects->where('status', 'awaiting_manual_review')->count() }}
                                </div>
                                <div class="text-sm text-theme-muted mt-1">
                                    {{ __('frontend.academic.awaiting_approval') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 px-6 py-4 shadow-lg text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-6 py-4 shadow-lg text-red-600">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <form action="/settings/academic/update" method="POST" class="space-y-8">
            @csrf

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.academic.personal_info') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.academic.full_name') }}
                        </label>
                        <input type="text" name="full_name"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.academic.academic_title') }}
                        </label>
                        <input type="text" name="academic_title"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.academic.email') }}
                        </label>
                        <input type="email" name="email"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.academic.phone') }}
                        </label>
                        <input type="tel" name="phone"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
                    </div>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.academic.institution_details') }}
                </h2>

                <div class="space-y-4">
                    <input type="text" name="institution"
                           placeholder="{{ __('frontend.academic.institution_name') }}"
                           class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">

                    <input type="text" name="department"
                           placeholder="{{ __('frontend.academic.department') }}"
                           class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.academic.notifications') }}
                </h2>

                <label class="flex items-center">
                    <input type="checkbox" name="notif_status_change">
                    <span class="ml-3">{{ __('frontend.academic.notif_status') }}</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="notif_investor_interest">
                    <span class="ml-3">{{ __('frontend.academic.notif_investor') }}</span>
                </label>
            </div>

            <div class="text-right">
                <button class="px-8 py-3 bg-brand-accent text-white rounded-lg">
                    {{ __('frontend.academic.save_changes') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection