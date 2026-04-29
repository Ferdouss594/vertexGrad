@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-80 w-80 blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 pt-32 pb-16">
        <div class="w-full max-w-lg">

            <div class="theme-panel register-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 lg:p-10">

                {{-- HEADER --}}
                <div class="text-center mb-8 register-header">

                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M5 6h14M6 14h12M7 18h10"/>
                        </svg>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-theme-text">
                        {{ __('frontend.auth.investor') }}
                        <span class="text-brand-accent">{{ __('frontend.auth.registration') }}</span>
                    </h2>

                    <p class="text-theme-muted mt-2 text-sm sm:text-base">
                        {{ __('frontend.auth.investor_register_text') }}
                    </p>
                </div>

                {{-- ERRORS --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                        <ul class="list-disc list-inside space-y-1 text-start">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('register.investor.post') }}" class="space-y-5 register-form" id="investorRegisterForm">
                    @csrf

                    @foreach([
                        ['name'=>'name','label'=>__('frontend.auth.full_name_entity_name')],
                        ['name'=>'username','label'=>__('frontend.auth.username')],
                        ['name'=>'email','label'=>__('frontend.auth.business_email'),'type'=>'email'],
                    ] as $field)
                        <div>
                            <label class="block text-sm font-bold text-theme-muted mb-2">
                                {{ $field['label'] }}
                            </label>
                            <input
                                type="{{ $field['type'] ?? 'text' }}"
                                name="{{ $field['name'] }}"
                                value="{{ old($field['name']) }}"
                                required
                                class="register-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3 px-4 text-theme-text focus:border-brand-accent focus:ring-0 transition"
                            >
                        </div>
                    @endforeach

                    {{-- PASSWORD --}}
                    <div class="relative">
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.password') }}
                        </label>
                        <input type="password" name="password" required class="register-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3 px-4 pe-12 text-theme-text">
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.confirm_password') }}
                        </label>
                        <input type="password" name="password_confirmation" required class="register-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3 px-4 pe-12 text-theme-text">
                    </div>

                    <button type="submit" class="register-submit w-full rounded-2xl py-3 font-bold bg-brand-accent text-white hover:bg-brand-accent-strong transition">
                        {{ __('frontend.auth.create_investor_account') }}
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-theme-muted">
                    {{ __('frontend.auth.already_have_account') }}
                    <a href="{{ route('login.show') }}" class="text-brand-accent font-bold underline">
                        {{ __('frontend.auth.log_in') }}
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('investorRegisterForm');
    const btn = form?.querySelector('button');

    form?.addEventListener('submit', () => {
        btn.innerHTML = `<span class="inline-flex items-center gap-2">
            <span class="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
            {{ __('frontend.auth.create_investor_account') }}
        </span>`;
    });

});
</script>
@endsection