@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-lg p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="text-center mb-8">
            <i class="fas fa-satellite-dish text-5xl text-brand-accent mb-4 block"
               style="filter: drop-shadow(0 0 10px var(--brand-accent-glow));"></i>
        </div>

        <h2 class="text-4xl font-bold text-center text-theme-text mb-2">
            {{ __('frontend.auth.sign_in_to') }} <span class="text-brand-accent">{{ __('frontend.auth.vertexgrad') }}</span>
        </h2>

        <p class="text-center text-theme-muted mb-10">
            {{ __('frontend.auth.login_subtitle') }}
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-2">{{ __('frontend.auth.username_or_email') }}</label>
                <input
                    type="text"
                    name="login_id"
                    value="{{ old('login_id') }}"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-theme-muted mb-2">{{ __('frontend.auth.password') }}</label>
                <input
                    type="password"
                    id="loginPassword"
                    name="password"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted pr-10 focus:ring-0 focus:border-brand-accent"
                >
                <button
                    type="button"
                    onclick="togglePassword('loginPassword', this)"
                    class="absolute right-3 top-10 text-theme-muted hover:text-brand-accent transition"
                >
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <div>
                <label class="block text-sm font-medium text-theme-muted mb-2">{{ __('frontend.auth.login_as') }}</label>
                <select
                    name="role"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="">{{ __('frontend.auth.select_role') }}</option>
                    <option value="Student">{{ __('frontend.auth.student') }}</option>
                    <option value="Investor">{{ __('frontend.auth.investor') }}</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-theme-muted cursor-pointer">
                    <input
                        type="checkbox"
                        name="remember"
                        class="mr-2 rounded border-theme-border bg-theme-surface-2 text-brand-accent focus:ring-brand-accent"
                    >
                    {{ __('frontend.auth.remember_me') }}
                </label>

                <a href="#" class="text-sm text-brand-accent hover:underline">
                    {{ __('frontend.auth.forgot_password_short') }}
                </a>
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
            >
                {{ __('frontend.auth.log_in') }}
            </button>
        </form>

        <p class="mt-8 text-center text-theme-muted text-sm">
            {{ __('frontend.auth.no_account') }}
            <a href="{{ route('register.show') }}" class="text-brand-accent underline">
                {{ __('frontend.auth.register_here') }}
            </a>
        </p>
    </div>
</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection