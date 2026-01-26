@php
    // Assuming these variables are available from a config or base layout
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    // Assuming card colors are defined
    $cardBg = '#1E293B'; // A dark, slightly lighter background for the card
@endphp

@extends('layouts.app')

@section('content')
{{-- 
    OUTER CONTAINER: Retains the full background color and ensures content is centered (min-h-screen).
--}}
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    
    {{-- 
        FORM CARD: Centered, constrained width (max-w-lg), and a distinct background/shadow.
        This container is the focus, not the entire page width.
    --}}
    <div class="w-full max-w-lg p-10 rounded-2xl border border-primary/30 
                shadow-[0_0_50px_rgba(30,227,247,0.2)]" 
         style="background-color: {{ $cardBg }};">
        
        <div class="text-center mb-8">
            {{-- Prominent Icon for branding --}}
            <i class="fas fa-satellite-dish text-5xl text-primary mb-4 block" 
               style="filter: drop-shadow(0 0 10px {{ $primaryColor }});">
            </i>
        </div>
        
        <h2 class="text-4xl font-bold text-center text-light mb-2">
            Sign In to <span class="text-primary">VertexGrad</span>
        </h2>
        <p class="text-center text-light/70 mb-10">
            Securely access your academic and investment dashboards.
        </p>

        <form action="/login" method="POST" class="space-y-6">
            @csrf
            
            {{-- Email Field --}}
            <div>
                <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address</label>
                <input type="email" id="email" name="email" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            {{-- Password Field --}}
            <div class="space-y-2 pb-2">
                <label for="password" class="block text-sm font-medium text-light/80 mb-2">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
                <a href="/forgot-password" class="text-sm text-primary hover:text-light block text-right">Forgot Password?</a>
            </div>

            {{-- Submit Button --}}
            <button type="submit" 
                    class="w-full {{ $btnPrimaryClass }} text-lg py-3 mt-6 shadow-neon_lg hover:shadow-primary/50 transition duration-200">
                Log In
            </button>
        </form>

        <p class="mt-8 text-center text-light/60 text-sm">
            Don't have an account?
            <a href="/register" class="text-primary hover:text-light font-medium ml-1 underline underline-offset-2">
                Register Here
            </a>
        </p>
    </div>
</div>
@endsection