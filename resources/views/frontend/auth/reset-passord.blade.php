@php
    // Assuming these variables are available from a config or base layout
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-md p-8 rounded-xl shadow-2xl border border-primary/20 bg-cardLight/70">
        
        <i class="fas fa-key text-4xl text-primary mb-4 block text-center"></i>
        <h2 class="text-3xl font-bold text-center text-light mb-2">
            Reset Your Password
        </h2>
        <p class="text-center text-light/70 mb-8">
            Set a new, strong password for your account.
        </p>

        <form action="/reset-password" method="POST">
            @csrf
            
            {{-- Password Reset Token (hidden field, usually automatically populated from URL) --}}
            <input type="hidden" name="token" value="{{ $token ?? '' }}">
            
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address</label>
                {{-- Email field is required and often pre-filled from the URL parameter --}}
                <input type="email" id="email" name="email" required value="{{ $email ?? old('email') }}" readonly
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary opacity-70">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-light/80 mb-2">New Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-medium text-light/80 mb-2">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <button type="submit" 
                    class="w-full {{ $btnPrimaryClass }} text-lg py-3 shadow-neon_sm">
                Reset Password
            </button>
        </form>
        
        <p class="mt-8 text-center text-light/60 text-sm">
            <a href="/login" class="text-primary hover:text-light font-medium ml-1">
                <i class="fas fa-arrow-left mr-1"></i> Back to Login
            </a>
        </p>
    </div>
</div>
@endsection