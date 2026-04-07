@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 pt-28 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('frontend.projects.show', $project) }}" class="text-brand-accent hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    {{ __('frontend.investor_summary.back_to_project') }}
                </a>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('investor.projects.pitch-deck.download', $project) }}"
                   class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-brand-accent text-white font-bold hover:bg-brand-accent-strong transition">
                    <i class="fas fa-file-powerpoint mr-2"></i>
                    {{ __('frontend.investor_summary.download_powerpoint') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <span class="text-brand-accent font-bold uppercase tracking-widest text-xs">
                        {{ $summary['category'] ?: __('frontend.investor_summary.uncategorized') }}
                    </span>

                    <h1 class="text-4xl font-bold text-theme-text mt-2">
                        {{ $summary['title'] ?: __('frontend.investor_summary.project_summary') }}
                    </h1>

                    <div class="mt-8">
                        <h3 class="text-theme-text font-bold text-xl mb-4">
                            {{ __('frontend.investor_summary.executive_summary') }}
                        </h3>
                        <p class="text-theme-muted leading-relaxed italic text-lg">
                            "{{ $summary['description'] ?: __('frontend.investor_summary.not_available') }}"
                        </p>
                    </div>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.problem_statement') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['problem_statement'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.target_beneficiaries') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['target_beneficiaries'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.expected_impact') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['expected_impact'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.community_benefit') }}
                    </h3>
                    <p class="text-theme-muted leading-relaxed">
                        {{ $summary['community_benefit'] ?: __('frontend.investor_summary.not_available') }}
                    </p>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-6">
                        {{ __('frontend.investor_summary.milestones') }}
                    </h3>

                    <div class="space-y-4">
                        @forelse($summary['milestones'] as $milestone)
                            <div class="p-5 rounded-2xl border border-theme-border bg-theme-surface-2">
                                <div class="font-bold text-theme-text">
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

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <p class="text-theme-muted text-xs uppercase font-bold mb-1">
                        {{ __('frontend.investor_summary.estimated_budget') }}
                    </p>

                    <h2 class="text-4xl font-black text-green-600">
                        ${{ is_numeric($summary['budget']) ? number_format($summary['budget']) : '0' }}
                    </h2>

                    <div class="mt-6 pt-6 border-t border-theme-border space-y-4">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.student') }}:</span>
                            <span class="text-brand-accent font-bold text-right">{{ $summary['student_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.academic_level') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['academic_level'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.supervisor') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['supervisor_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.university') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['university_name'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.department') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['department'] ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.funding_overview') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.needs_funding') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['needs_funding'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.duration_months') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['duration_months'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.support_type') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['support_type'] ?: '-' }}</span>
                        </div>

                        <div>
                            <div class="text-theme-muted mb-2">{{ __('frontend.investor_summary.budget_breakdown') }}:</div>
                            <div class="text-theme-text font-semibold leading-relaxed">
                                {{ $summary['budget_breakdown'] ?: __('frontend.investor_summary.not_available') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.readiness') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.scanner_status') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['scanner_status'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.scan_score') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['scan_score'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.final_decision') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['final_decision'] ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.approved_reviews') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['approved_reviews_count'] ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.approved_investments') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $summary['approved_investments_count'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                    <h3 class="text-theme-text font-bold text-xl mb-4">
                        {{ __('frontend.investor_summary.latest_deck') }}
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.status') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $latestDeck->status ?? __('frontend.investor_summary.not_generated_yet') }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.version') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ $latestDeck->version ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-theme-muted">{{ __('frontend.investor_summary.generated_at') }}:</span>
                            <span class="text-theme-text font-bold text-right">{{ optional($latestDeck?->generated_at)->format('Y-m-d H:i') ?: '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection