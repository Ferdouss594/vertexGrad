@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 pt-28 bg-theme-bg transition-colors duration-300 overflow-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="summary-top mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('frontend.projects.show', $project) }}" class="inline-flex items-center text-brand-accent hover:underline font-bold">
                    <i class="fas fa-arrow-left me-2 rtl:rotate-180"></i>
                    {{ __('frontend.investor_summary.back_to_project') }}
                </a>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('investor.projects.pitch-deck.download', $project) }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-brand-accent text-white font-bold hover:bg-brand-accent-strong transition shadow-brand-soft">
                    <i class="fas fa-file-powerpoint me-2"></i>
                    {{ __('frontend.investor_summary.download_powerpoint') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <span class="text-brand-accent font-bold uppercase tracking-widest text-xs">
                        {{ $summary['category'] ?: __('frontend.investor_summary.uncategorized') }}
                    </span>

                    <h1 class="text-3xl sm:text-4xl font-black text-theme-text mt-2 leading-tight break-words">
                        {{ $summary['title'] ?: __('frontend.investor_summary.project_summary') }}
                    </h1>

                    <div class="mt-8">
                        <h3 class="text-theme-text font-bold text-xl mb-4">
                            {{ __('frontend.investor_summary.executive_summary') }}
                        </h3>
                        <p class="text-theme-muted leading-relaxed italic text-base sm:text-lg">
                            "{{ $summary['description'] ?: __('frontend.investor_summary.not_available') }}"
                        </p>
                    </div>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.problem_statement') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['problem_statement'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.target_beneficiaries') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['target_beneficiaries'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.expected_impact') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['expected_impact'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.community_benefit') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['community_benefit'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-6">
                        {{ __('frontend.investor_summary.milestones') }}
                    </h3>

                    <div class="space-y-4">
                        @forelse($summary['milestones'] as $milestone)
                            <div class="summary-milestone p-5 rounded-2xl border border-theme-border bg-theme-surface-2">
                                <div class="font-bold text-theme-text break-words">
                                    {{ $milestone['title'] }}
                                </div>
                                <div class="text-sm text-theme-muted mt-2">
                                    {{ __('frontend.investor_summary.month') }}: {{ $milestone['month'] ?: '-' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-theme-muted italic">
                                {{ __('frontend.investor_summary.no_milestones') }}
                            </p>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <p class="text-theme-muted text-xs uppercase font-bold mb-1">
                        {{ __('frontend.investor_summary.estimated_budget') }}
                    </p>

                    <h2 class="summary-budget text-3xl sm:text-4xl font-black text-green-600">
                        ${{ is_numeric($summary['budget']) ? number_format($summary['budget']) : '0' }}
                    </h2>

                    <div class="mt-6 pt-6 border-t border-theme-border space-y-4">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.student') }}:</span>
                            <span class="text-brand-accent font-bold text-end">{{ $summary['student_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.academic_level') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['academic_level'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.supervisor') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['supervisor_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.university') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['university_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.department') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['department'] ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.funding_overview') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.needs_funding') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['needs_funding'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.duration_months') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['duration_months'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.support_type') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['support_type'] ?: '-' }}</span>
                        </div>

                        <div>
                            <div class="text-theme-muted mb-2">{{ __('frontend.investor_summary.budget_breakdown') }}:</div>
                            <div class="text-theme-text font-semibold leading-relaxed break-words">
                                {{ $summary['budget_breakdown'] ?: __('frontend.investor_summary.not_available') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.readiness') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.scanner_status') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['scanner_status'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.scan_score') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['scan_score'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.final_decision') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['final_decision'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.approved_reviews') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['approved_reviews_count'] ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.approved_investments') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $summary['approved_investments_count'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="summary-card theme-panel p-6 sm:p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.latest_deck') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.status') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $latestDeck->status ?? __('frontend.investor_summary.not_generated_yet') }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.version') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ $latestDeck->version ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.generated_at') }}:</span>
                            <span class="text-theme-text font-bold text-end">{{ optional($latestDeck?->generated_at)->format('Y-m-d H:i') ?: '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-investor-summary-style')) {
        const style = document.createElement('style');
        style.id = 'vg-investor-summary-style';
        style.innerHTML = `
            .summary-top,
            .summary-card,
            .summary-milestone {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .75s ease, transform .75s cubic-bezier(.22,1,.36,1), box-shadow .28s ease;
            }

            .summary-top.is-visible,
            .summary-card.is-visible,
            .summary-milestone.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .summary-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 44px rgba(0,0,0,.09);
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(0,224,255,.16);
                border-radius: 12px;
            }

            @media (max-width: 767px) {
                .summary-card:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .summary-top,
                .summary-card,
                .summary-milestone {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [
        document.querySelector('.summary-top'),
        ...document.querySelectorAll('.summary-card'),
        ...document.querySelectorAll('.summary-milestone')
    ].filter(Boolean).forEach((el, index) => {
        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 85));
    });

    if (!prefersReducedMotion) {
        const budgetEl = document.querySelector('.summary-budget');

        if (budgetEl) {
            const originalText = budgetEl.textContent.trim();
            const value = parseInt(originalText.replace(/[^\d]/g, ''), 10);

            if (!Number.isNaN(value)) {
                budgetEl.textContent = '$0';

                const start = performance.now();
                const duration = 1200;

                function animate(now) {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(value * eased);

                    budgetEl.textContent = '$' + current.toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        budgetEl.textContent = '$' + value.toLocaleString();
                    }
                }

                setTimeout(() => requestAnimationFrame(animate), 500);
            }
        }
    }

    document.querySelectorAll('a, button').forEach((el) => {
        el.classList.add('vg-focus-ring');
    });
});
</script>
@endsection