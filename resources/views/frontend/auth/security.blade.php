@extends('frontend.layouts.app')

@section('content')
@php
    $eventLabel = function ($event) {
        $key = 'frontend.security.event_' . $event;
        $translated = __($key);

        return $translated === $key
            ? str_replace('_', ' ', ucfirst($event))
            : $translated;
    };

    $eventBadgeClass = function ($event, $isSuccess) {
        return match ($event) {
            'recovery_codes_regenerated', 'recovery_codes_downloaded', 'trusted_device_added', 'login_completed_trusted_device' =>
                'bg-brand-accent/10 text-brand-accent border border-brand-accent/20',
            'otp_failed', 'password_login_failed', 'recovery_code_failed', 'otp_expired', 'otp_locked' =>
                'bg-red-500/10 text-red-500 border border-red-500/20',
            'suspicious_login_alert_sent' =>
                'bg-yellow-500/10 text-yellow-700 border border-yellow-500/20',
            default => $isSuccess
                ? 'bg-green-500/10 text-green-600 border border-green-500/20'
                : 'bg-red-500/10 text-red-500 border border-red-500/20',
        };
    };
@endphp

<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300 overflow-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <header class="security-reveal">
            <div class="relative overflow-hidden theme-panel rounded-3xl lg:rounded-[2.5rem] shadow-brand-soft">
                <div class="p-6 sm:p-8 md:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                        <div class="flex flex-col sm:flex-row items-start gap-5">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-brand-accent-soft border border-brand-accent flex items-center justify-center shrink-0 text-brand-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/>
                                    <path d="M9.5 12l1.8 1.8L15 10"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-[0.15em] border border-brand-accent mb-4">
                                    {{ __('frontend.security.badge') }}
                                </div>

                                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-theme-text tracking-tight leading-[1.1]">
                                    {{ __('frontend.security.title_highlight') }}
                                    <span class="text-brand-accent">{{ __('frontend.security.title') }}</span>
                                </h1>

                                <p class="text-theme-muted mt-4 text-sm md:text-base leading-7 max-w-3xl">
                                    {{ __('frontend.security.subtitle') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <a href="{{ auth()->user()?->role === 'Investor' ? route('settings.investor') : route('settings.academic') }}"
                               class="inline-flex items-center justify-center rounded-2xl px-5 sm:px-6 py-3 font-bold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 me-2 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7" />
                                </svg>
                                {{ __('frontend.security.back_to_settings') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="h-1.5 w-full bg-theme-surface-2">
                    <div class="h-full bg-brand-accent w-1/2"></div>
                </div>
            </div>
        </header>

        @if (session('status'))
            <div class="security-reveal p-4 rounded-2xl border border-green-500/40 bg-green-500/10 text-green-600 shadow-brand-soft">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="security-reveal p-5 rounded-2xl border border-red-500/40 bg-red-500/10 text-red-600 shadow-brand-soft">
                <div class="font-black uppercase tracking-[0.14em] text-xs mb-3">
                    {{ __('frontend.academic.fix_issues') }}
                </div>
                <ul class="list-disc ps-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 lg:gap-8">
            <section class="security-reveal theme-panel rounded-3xl lg:rounded-[2.5rem] p-5 sm:p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <h2 class="text-lg sm:text-xl font-black text-theme-text uppercase tracking-[0.12em] sm:tracking-[0.16em]">
                        {{ __('frontend.security.active_sessions') }}
                    </h2>
                    <span class="text-xs font-mono text-theme-muted">
                        {{ __('frontend.security.total') }}: {{ $sessions->count() }}
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse ($sessions as $session)
                        <div class="theme-panel-soft rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-theme-text font-bold break-words">
                                    {{ $session->browser }} • {{ $session->os }} • {{ $session->device }}
                                </div>
                                <div class="text-sm text-theme-muted mt-2">
                                    {{ __('frontend.security.ip') }}: {{ $session->ip_address ?? 'Unknown' }}
                                </div>
                                <div class="text-sm text-theme-muted">
                                    {{ __('frontend.security.last_activity') }}: {{ $session->last_activity->diffForHumans() }}
                                </div>

                                @if ($session->is_current)
                                    <div class="mt-3 inline-flex rounded-xl px-3 py-1 text-[10px] font-black uppercase tracking-[0.15em] bg-brand-accent-soft text-brand-accent border border-brand-accent">
                                        {{ __('frontend.security.current_session') }}
                                    </div>
                                @endif
                            </div>

                            @unless ($session->is_current)
                                <form method="POST" action="{{ route('security.sessions.revoke', $session->id) }}" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl px-4 py-2 text-xs font-black uppercase tracking-[0.14em] border border-red-500/30 text-red-500 hover:bg-red-500/10 transition">
                                        {{ __('frontend.security.revoke') }}
                                    </button>
                                </form>
                            @endunless
                        </div>
                    @empty
                        <div class="theme-panel-soft rounded-2xl p-5 text-theme-muted text-sm">
                            {{ __('frontend.security.no_active_sessions') }}
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="security-reveal theme-panel rounded-3xl lg:rounded-[2.5rem] p-5 sm:p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <h2 class="text-lg sm:text-xl font-black text-theme-text uppercase tracking-[0.12em] sm:tracking-[0.16em]">
                        {{ __('frontend.security.trusted_devices') }}
                    </h2>
                    <span class="text-xs font-mono text-theme-muted">
                        {{ __('frontend.security.total') }}: {{ $trustedDevices->count() }}
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse ($trustedDevices as $device)
                        <div class="theme-panel-soft rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-theme-text font-bold break-words">
                                    {{ $device->browser ?? 'Unknown Browser' }} • {{ $device->os ?? 'Unknown OS' }}
                                </div>
                                <div class="text-sm text-theme-muted mt-2">
                                    {{ __('frontend.security.device') }}: {{ $device->device_name ?? 'Unknown Device' }}
                                </div>
                                <div class="text-sm text-theme-muted">
                                    {{ __('frontend.security.ip') }}: {{ $device->ip_address ?? 'Unknown' }}
                                </div>
                                <div class="text-sm text-theme-muted">
                                    {{ __('frontend.security.expires') }}: {{ optional($device->expires_at)->diffForHumans() }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('security.trusted-devices.revoke', $device->id) }}" class="shrink-0">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl px-4 py-2 text-xs font-black uppercase tracking-[0.14em] border border-red-500/30 text-red-500 hover:bg-red-500/10 transition">
                                    {{ __('frontend.security.remove') }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="theme-panel-soft rounded-2xl p-5 text-theme-muted text-sm">
                            {{ __('frontend.security.no_trusted_devices') }}
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="security-reveal theme-panel rounded-3xl lg:rounded-[2.5rem] p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-theme-text uppercase tracking-[0.12em] sm:tracking-[0.16em]">
                        {{ __('frontend.security.logout_other_devices') }}
                    </h2>
                    <p class="text-sm text-theme-muted mt-2">
                        {{ __('frontend.security.logout_other_devices_text') }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('security.logout-other-devices') }}" class="max-w-md space-y-4 security-form">
                @csrf

                <div class="theme-panel-soft rounded-2xl p-4">
                    <label class="mb-2 block text-sm font-bold text-theme-text">
                        {{ __('frontend.security.current_password') }}
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-theme-border bg-theme-surface py-3 px-4 text-theme-text focus:border-brand-accent focus:ring-0"
                    >
                </div>

                <button type="submit" class="security-danger-btn inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-black uppercase tracking-[0.14em] bg-red-500 text-white hover:opacity-90 transition shadow-brand-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v9m6.36-6.36A9 9 0 1 1 5.64 5.64" />
                    </svg>
                    <span>{{ __('frontend.security.logout_other_devices') }}</span>
                </button>
            </form>
        </section>

        <section class="security-reveal theme-panel rounded-3xl lg:rounded-[2.5rem] p-5 sm:p-6 md:p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-6">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-theme-text uppercase tracking-[0.12em] sm:tracking-[0.16em]">
                        {{ __('frontend.security.recovery_codes') }}
                    </h2>
                    <p class="text-sm text-theme-muted mt-2">
                        {{ __('frontend.security.recovery_codes_text') }}
                    </p>
                </div>

                <div class="text-xs font-mono text-theme-muted">
                    {{ __('frontend.security.available') }}: {{ $recoveryCodesCount ?? 0 }}
                </div>
            </div>

            @if (session('recovery_codes'))
                <div class="mb-6 rounded-2xl border border-yellow-500/30 bg-yellow-500/10 p-5">
                    <div class="text-sm font-bold text-yellow-700 mb-3">
                        {{ __('frontend.security.recovery_codes_saved_once') }}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach (session('recovery_codes') as $code)
                            <div class="rounded-xl bg-theme-surface-2 border border-theme-border px-4 py-3 font-mono text-theme-text break-all">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('security.recovery-codes.download') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3 text-sm font-black uppercase tracking-[0.14em] border border-theme-border text-theme-text hover:bg-theme-surface-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 21h16" />
                            </svg>
                            <span>{{ __('frontend.security.download_recovery_codes') }}</span>
                        </a>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('security.recovery-codes.regenerate') }}" onsubmit="return confirm(@js(__('frontend.security.confirm_regenerate_recovery_codes')))">
                @csrf
                <button type="submit" class="security-primary-btn inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-black uppercase tracking-[0.14em] bg-brand-accent text-white hover:bg-brand-accent-strong transition shadow-brand-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a4 4 0 1 0-3.46 3.96L9 13.5V16h2.5L14 13.5V11h2.5L19 8.5V7h-4z" />
                    </svg>
                    <span>{{ __('frontend.security.generate_recovery_codes') }}</span>
                </button>
            </form>
        </section>

        <section class="security-reveal theme-panel rounded-3xl lg:rounded-[2.5rem] p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <h2 class="text-lg sm:text-xl font-black text-theme-text uppercase tracking-[0.12em] sm:tracking-[0.16em]">
                    {{ __('frontend.security.recent_activity') }}
                </h2>
                <span class="text-xs font-mono text-theme-muted">
                    {{ __('frontend.security.latest_events') }}
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-theme-border">
                <table class="min-w-[860px] w-full text-sm">
                    <thead class="bg-theme-surface-2">
                        <tr class="text-start text-theme-muted border-b border-theme-border">
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.event') }}</th>
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.status') }}</th>
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.ip') }}</th>
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.browser') }}</th>
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.os') }}</th>
                            <th class="py-3 px-4 text-start">{{ __('frontend.security.when') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentActivities as $activity)
                            <tr class="border-b border-theme-border/50 last:border-b-0">
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-xl px-3 py-1 text-[11px] font-bold {{ $eventBadgeClass($activity->event, $activity->is_success) }}">
                                        {{ $eventLabel($activity->event) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-xl px-3 py-1 text-[11px] font-bold {{ $activity->is_success ? 'bg-green-500/10 text-green-600 border border-green-500/20' : 'bg-red-500/10 text-red-500 border border-red-500/20' }}">
                                        {{ $activity->is_success ? __('frontend.security.success') : __('frontend.security.failed') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-theme-muted">{{ $activity->ip_address }}</td>
                                <td class="py-3 px-4 text-theme-muted">{{ $activity->browser }}</td>
                                <td class="py-3 px-4 text-theme-muted">{{ $activity->os }}</td>
                                <td class="py-3 px-4 text-theme-muted whitespace-nowrap">{{ $activity->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-theme-muted text-center">
                                    {{ __('frontend.security.no_recent_activity') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-security-style')) {
        const style = document.createElement('style');
        style.id = 'vg-security-style';
        style.textContent = `
            .security-reveal {
                opacity: 0;
                transform: translateY(22px);
                transition: opacity .7s ease, transform .7s cubic-bezier(.22,1,.36,1);
            }

            .security-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .security-primary-btn,
            .security-danger-btn {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .security-primary-btn:hover,
            .security-danger-btn:hover {
                transform: translateY(-1px);
            }

            @media (prefers-reduced-motion: reduce) {
                .security-reveal,
                .security-primary-btn,
                .security-danger-btn {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    document.querySelectorAll('.security-reveal').forEach((el, index) => {
        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 80 + (index * 80));
    });

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');

            if (!button || button.dataset.loadingApplied === 'true') {
                return;
            }

            button.dataset.loadingApplied = 'true';
            button.style.opacity = '0.88';
            button.style.pointerEvents = 'none';
        });
    });
});
</script>
@endsection