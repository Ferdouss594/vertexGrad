@php
    $openRoles = [
        ['title' => 'Vetting Analyst (Biotech Focus)', 'location' => 'Remote / London', 'type' => 'Full-time'],
        ['title' => 'Senior Backend Engineer (Laravel/PHP)', 'location' => 'Remote / Zurich', 'type' => 'Full-time'],
        ['title' => 'UX/UI Designer', 'location' => 'Remote', 'type' => 'Contract'],
    ];
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.careers.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.careers.title_highlight') }}</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-3xl mx-auto">
                {{ __('frontend.careers.subtitle') }}
            </p>
        </header>

        <h2 class="text-3xl font-bold text-theme-text mb-8 border-b border-theme-border pb-3">
            {{ __('frontend.careers.open_positions') }} ({{ count($openRoles) }})
        </h2>

        <div class="space-y-4">
            @foreach($openRoles as $role)
                <div class="theme-panel p-6 rounded-xl flex justify-between items-center hover:shadow-brand-soft transition duration-300">
                    <div>
                        <h3 class="text-2xl font-semibold text-theme-text">{{ $role['title'] }}</h3>
                        <p class="text-theme-muted mt-1">
                            {{ $role['location'] }} &middot; <span class="text-brand-accent">{{ $role['type'] }}</span>
                        </p>
                    </div>

                    <a href="/careers/apply/{{ strtolower(str_replace([' ', '(', ')'], '-', $role['title'])) }}"
                       class="text-brand-accent hover:text-theme-text transition-colors duration-300 font-medium">
                        {{ __('frontend.careers.view_apply') }} <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-16 p-8 bg-brand-accent-soft border border-brand-accent/30 rounded-xl text-center">
            <h3 class="text-2xl font-bold text-theme-text">{{ __('frontend.careers.no_match_title') }}</h3>
            <p class="text-lg text-brand-accent mt-2">
                {{ __('frontend.careers.no_match_text') }}
                <a href="/contact" class="hover:underline">{{ __('frontend.careers.contact_hr') }}</a>
            </p>
        </div>

    </div>
</div>
@endsection