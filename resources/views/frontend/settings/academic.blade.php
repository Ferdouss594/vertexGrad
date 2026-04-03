@extends('frontend.layouts.app')

@section('content')
@php
    $btnPrimaryClass = 'inline-flex items-center justify-center rounded-2xl px-8 py-4 font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft';
    $btnSecondaryClass = 'inline-flex items-center justify-center rounded-2xl px-6 py-3 font-bold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300';
@endphp

<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <header class="mb-10">
            <div class="relative overflow-hidden theme-panel rounded-[2.5rem] shadow-brand-soft">
                <div class="p-8 md:p-10">
                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-8">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-5 flex-wrap">
                                <span class="px-4 py-1.5 rounded-xl bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-[0.15em] border border-brand-accent">
                                    {{ __('frontend.academic.profile_settings_badge') }}
                                </span>
                                <span class="text-theme-muted text-xs font-mono">
                                    ID: STD-{{ $user->id + 5000 }}
                                </span>
                            </div>

                            <h1 class="text-3xl md:text-5xl font-black text-theme-text tracking-tight leading-[1.1]">
                                {{ __('frontend.academic.dashboard_title_before') }}
                                <span class="text-brand-accent">{{ __('frontend.academic.dashboard_title_highlight') }}</span>
                            </h1>

                            <p class="text-theme-muted mt-4 text-sm md:text-base leading-7 max-w-3xl">
                                {{ __('frontend.academic.dashboard_subtitle') }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-3">
                                <a href="{{ route('dashboard.academic') }}" class="{{ $btnSecondaryClass }}">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    {{ __('frontend.academic.back_to_dashboard') }}
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 xl:min-w-[320px]">
                            <div class="theme-panel-soft rounded-2xl p-5 text-center">
                                <div class="text-3xl font-black text-theme-text">
                                    {{ isset($projects) ? $projects->count() : 0 }}
                                </div>
                                <div class="text-xs uppercase tracking-[0.18em] font-black text-theme-muted mt-2">
                                    {{ __('frontend.academic.projects') }}
                                </div>
                            </div>

                            <div class="theme-panel-soft rounded-2xl p-5 text-center">
                                <div class="text-3xl font-black text-theme-text">
                                    {{ isset($projects) ? $projects->where('status', 'awaiting_manual_review')->count() : 0 }}
                                </div>
                                <div class="text-xs uppercase tracking-[0.18em] font-black text-theme-muted mt-2">
                                    {{ __('frontend.academic.awaiting_approval') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-1.5 w-full bg-theme-surface-2">
                    <div class="h-full bg-brand-accent w-1/2"></div>
                </div>
            </div>
        </header>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="p-4 rounded-2xl border border-green-500/40 bg-green-500/10 text-green-600 shadow-brand-soft">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6">
                <div class="p-4 rounded-2xl border border-red-500/40 bg-red-500/10 text-red-600 shadow-brand-soft">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6">
                <div class="p-5 rounded-2xl border border-red-500/40 bg-red-500/10 text-red-600 shadow-brand-soft">
                    <div class="font-black uppercase tracking-[0.14em] text-xs mb-3">
                        {{ __('frontend.academic.fix_issues') }}
                    </div>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('settings.academic.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Personal / Photo --}}
            <section class="theme-panel rounded-[2.5rem] p-6 md:p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-[320px] shrink-0">
                        <div class="theme-panel-soft rounded-[2rem] p-6 h-full">
                            <div class="flex items-center justify-between gap-3 mb-5">
                                <h2 class="text-lg font-black text-theme-text uppercase tracking-[0.16em]">
                                    {{ __('frontend.academic.profile_photo') }}
                                </h2>
                            </div>

                            <div class="flex flex-col items-center text-center">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-theme-border shadow-brand-soft bg-theme-surface-2">
                                    <img
                                        src="{{ !empty($user->profile_image) ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}"
                                        alt="{{ $user->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>

                                <div class="mt-5 text-theme-text font-bold">
                                    {{ $user->name }}
                                </div>
                                <div class="text-sm text-theme-muted mt-1 break-all">
                                    {{ $user->email }}
                                </div>

                                <div class="w-full mt-6">
                                    <label class="block text-sm font-bold text-theme-text mb-2 text-left">
                                        {{ __('frontend.academic.choose_new_photo') }}
                                    </label>
                                    <input
                                        type="file"
                                        name="profile_image"
                                        accept="image/*"
                                        class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                    >
                                    <p class="text-xs text-theme-muted mt-2 text-left">
                                        {{ __('frontend.academic.photo_hint') }}
                                    </p>
                                    @error('profile_image')
                                        <p class="text-sm text-red-500 mt-2 text-left">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                            <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.16em]">
                                {{ __('frontend.academic.personal_info') }}
                            </h2>
                            <span class="text-xs font-mono text-theme-muted">
                                {{ __('frontend.academic.account_information_hint') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="theme-panel-soft rounded-2xl p-4">
                                <label class="block text-sm font-bold text-theme-text mb-2">
                                    {{ __('frontend.academic.full_name') }}
                                </label>
                                <input
                                    type="text"
                                    name="full_name"
                                    value="{{ old('full_name', $user->name) }}"
                                    class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                >
                                @error('full_name')
                                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="theme-panel-soft rounded-2xl p-4">
                                <label class="block text-sm font-bold text-theme-text mb-2">
                                    {{ __('frontend.academic.academic_title') }}
                                </label>
                                <input
                                    type="text"
                                    name="academic_title"
                                    value="{{ old('academic_title', $user->academic_title ?? '') }}"
                                    class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                >
                                @error('academic_title')
                                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="theme-panel-soft rounded-2xl p-4">
                                <label class="block text-sm font-bold text-theme-text mb-2">
                                    {{ __('frontend.academic.email') }}
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                >
                                @error('email')
                                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="theme-panel-soft rounded-2xl p-4">
                                <label class="block text-sm font-bold text-theme-text mb-2">
                                    {{ __('frontend.academic.phone') }}
                                </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}"
                                    class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                                >
                                @error('phone')
                                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Institution --}}
            <section class="theme-panel rounded-[2.5rem] p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.16em]">
                        {{ __('frontend.academic.institution_details') }}
                    </h2>
                    <span class="text-xs font-mono text-theme-muted">
                        {{ __('frontend.academic.institution_hint') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="theme-panel-soft rounded-2xl p-4">
                        <label class="block text-sm font-bold text-theme-text mb-2">
                            {{ __('frontend.academic.institution_name') }}
                        </label>
                        <input
                            type="text"
                            name="institution"
                            value="{{ old('institution', $user->institution ?? '') }}"
                            class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                        >
                        @error('institution')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="theme-panel-soft rounded-2xl p-4">
                        <label class="block text-sm font-bold text-theme-text mb-2">
                            {{ __('frontend.academic.department') }}
                        </label>
                        <input
                            type="text"
                            name="department"
                            value="{{ old('department', $user->department ?? '') }}"
                            class="w-full p-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text"
                        >
                        @error('department')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Notifications --}}
            <section class="theme-panel rounded-[2.5rem] p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <h2 class="text-xl font-black text-theme-text uppercase tracking-[0.16em]">
                        {{ __('frontend.academic.notifications') }}
                    </h2>
                    <span class="text-xs font-mono text-theme-muted">
                        {{ __('frontend.academic.notification_preferences_hint') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <label class="theme-panel-soft rounded-2xl p-5 flex items-start gap-4 cursor-pointer">
                        <input
                            type="checkbox"
                            name="notif_status_change"
                            value="1"
                            class="mt-1"
                            {{ old('notif_status_change', $user->notif_status_change ?? false) ? 'checked' : '' }}
                        >
                        <div>
                            <div class="text-theme-text font-bold">
                                {{ __('frontend.academic.notif_status') }}
                            </div>
                            <div class="text-sm text-theme-muted mt-1">
                                {{ __('frontend.academic.notif_status_hint') }}
                            </div>
                        </div>
                    </label>

                    <label class="theme-panel-soft rounded-2xl p-5 flex items-start gap-4 cursor-pointer">
                        <input
                            type="checkbox"
                            name="notif_investor_interest"
                            value="1"
                            class="mt-1"
                            {{ old('notif_investor_interest', $user->notif_investor_interest ?? false) ? 'checked' : '' }}
                        >
                        <div>
                            <div class="text-theme-text font-bold">
                                {{ __('frontend.academic.notif_investor') }}
                            </div>
                            <div class="text-sm text-theme-muted mt-1">
                                {{ __('frontend.academic.notif_investor_hint') }}
                            </div>
                        </div>
                    </label>
                </div>
            </section>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('dashboard.academic') }}" class="{{ $btnSecondaryClass }}">
                    {{ __('frontend.academic.cancel') }}
                </a>

                <button type="submit" class="{{ $btnPrimaryClass }}">
                    <i class="fas fa-save mr-2"></i>
                    {{ __('frontend.academic.save_changes') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection