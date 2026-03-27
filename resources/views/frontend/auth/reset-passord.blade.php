@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-md p-8 rounded-xl theme-panel shadow-brand-soft">

        <i class="fas fa-key text-4xl text-brand-accent mb-4 block text-center"
           style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

        <h2 class="text-3xl font-bold text-center text-theme-text mb-2">
            Reset Your Password
        </h2>

        <p class="text-center text-theme-muted mb-8">
            Set a new, strong password for your account.
        </p>

        <form action="/reset-password" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-theme-muted mb-2">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="{{ $email ?? old('email') }}"
                    readonly
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted opacity-70 focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-theme-muted mb-2">New Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-medium text-theme-muted mb-2">Confirm New Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
            >
                Reset Password
            </button>
        </form>

        <p class="mt-8 text-center text-theme-muted text-sm">
            <a href="/login" class="text-brand-accent font-medium ml-1">
                <i class="fas fa-arrow-left mr-1"></i> Back to Login
            </a>
        </p>
    </div>
</div>
@endsection