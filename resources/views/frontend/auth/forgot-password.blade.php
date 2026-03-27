@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-md p-8 rounded-xl theme-panel shadow-brand-soft">

        <i class="fas fa-lock text-4xl text-brand-accent mb-4 block text-center"
           style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

        <h2 class="text-3xl font-bold text-center text-theme-text mb-2">
            Forgot Your Password?
        </h2>

        <p class="text-center text-theme-muted mb-8">
            Enter your email address below and we will send you a link to reset your password.
        </p>

        <form action="/forgot-password" method="POST">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-theme-muted mb-2">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
            >
                Send Reset Link
            </button>
        </form>

        <p class="mt-8 text-center text-theme-muted text-sm">
            Remember your password?
            <a href="/login" class="text-brand-accent font-medium ml-1">
                Log In
            </a>
        </p>
    </div>
</div>
@endsection