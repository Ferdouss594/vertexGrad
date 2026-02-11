@php
    // Assuming these variables are available from a config or base layout
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-md p-8 rounded-xl shadow-2xl border border-primary/20 bg-cardLight/70">
        
        <i class="fas fa-lock text-4xl text-primary mb-4 block text-center"></i>
        <h2 class="text-3xl font-bold text-center text-light mb-2">
            Forgot Your Password?
        </h2>
        <p class="text-center text-light/70 mb-8">
            Enter your email address below and we will send you a link to reset your password.
        </p>

        <form action="/forgot-password" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address</label>
                <input type="email" id="email" name="email" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <button type="submit" 
                    class="w-full {{ $btnPrimaryClass }} text-lg py-3 shadow-neon_sm">
                Send Reset Link
            </button>
        </form>

        <p class="mt-8 text-center text-light/60 text-sm">
            Remember your password?
            <a href="/login" class="text-primary hover:text-light font-medium ml-1">
                Log In
            </a>
        </p>
    </div>
</div>
@endsection