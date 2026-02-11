@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-lg p-10 rounded-2xl border border-primary/30 shadow-[0_0_50px_rgba(30,227,247,0.2)]" style="background-color: {{ $cardBg }};">
        
        <h2 class="text-3xl font-bold text-center text-light mb-6">Academic <span class="text-primary">Registration</span></h2>

        <form method="POST" action="{{ route('register.student.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-light/80 mb-1">Full Name</label>
                <input type="text" name="name" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-light/80 mb-1">Username</label>
                <input type="text" name="username" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-light/80 mb-1">University Email</label>
                <input type="email" name="email" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-light/80 mb-1">Password</label>
                <input type="password" name="password" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-light/80 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>

            <button type="submit" class="w-full {{ $btnPrimaryClass }} py-3 mt-4">Create Academic Account</button>
        </form>
    </div>
</div>
@endsection