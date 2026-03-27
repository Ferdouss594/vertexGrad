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
                Join Our <span class="text-brand-accent">Mission</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-3xl mx-auto">
                We're a fast-growing team bridging the gap between academia and industry. Help us accelerate global innovation.
            </p>
        </header>

        <h2 class="text-3xl font-bold text-theme-text mb-8 border-b border-theme-border pb-3">
            Open Positions ({{ count($openRoles) }})
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
                        View & Apply <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-16 p-8 bg-brand-accent-soft border border-brand-accent/30 rounded-xl text-center">
            <h3 class="text-2xl font-bold text-theme-text">Don't see your role?</h3>
            <p class="text-lg text-brand-accent mt-2">
                Send us your CV anyway! We are always looking for exceptional talent.
                <a href="/contact" class="hover:underline">Contact our HR team.</a>
            </p>
        </div>

    </div>
</div>
@endsection