@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $cardBg = '#1E293B';
    $openRoles = [
        ['title' => 'Vetting Analyst (Biotech Focus)', 'location' => 'Remote / London', 'type' => 'Full-time'],
        ['title' => 'Senior Backend Engineer (Laravel/PHP)', 'location' => 'Remote / Zurich', 'type' => 'Full-time'],
        ['title' => 'UX/UI Designer', 'location' => 'Remote', 'type' => 'Contract'],
    ];
@endphp

@extends('frontend.layouts.app')

@section('content')

<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-light mb-4">
                Join Our <span class="text-primary">Mission</span>
            </h1>
            <p class="text-xl text-light/80 max-w-3xl mx-auto">
                We're a fast-growing team bridging the gap between academia and industry. Help us accelerate global innovation.
            </p>
        </header>

        <h2 class="text-3xl font-bold text-light mb-8 border-b border-light/20 pb-3">Open Positions (3)</h2>
        
        <div class="space-y-4">
            @foreach($openRoles as $role)
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg flex justify-between items-center hover:shadow-neon_sm transition duration-300">
                    <div>
                        <h3 class="text-2xl font-semibold text-light">{{ $role['title'] }}</h3>
                        <p class="text-light/70 mt-1">{{ $role['location'] }} &middot; <span class="text-primary">{{ $role['type'] }}</span></p>
                    </div>
                    <a href="/careers/apply/{{ strtolower(str_replace([' ', '(', ')'], '-', $role['title'])) }}" class="text-primary hover:text-light transition-colors duration-300 font-medium">
                        View & Apply <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-16 p-8 bg-primary/10 border border-primary/30 rounded-xl text-center">
            <h3 class="text-2xl font-bold text-light">Don't see your role?</h3>
            <p class="text-lg text-primary mt-2">
                Send us your CV anyway! We are always looking for exceptional talent. <a href="/contact" class="hover:underline">Contact our HR team.</a>
            </p>
        </div>

    </div>
</div>
@endsection