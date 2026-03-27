@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-lg p-10 rounded-2xl theme-panel shadow-brand-soft">

        <h2 class="text-3xl font-bold text-center text-theme-text mb-6">
            Academic <span class="text-brand-accent">Registration</span>
        </h2>

        <form method="POST" action="{{ route('register.student.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-1">Full Name</label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-1">Username</label>
                <input
                    type="text"
                    name="username"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-1">University Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft mt-4"
            >
                Create Academic Account
            </button>
        </form>
    </div>
</div>
@endsection