@php
    $authUser = auth('web')->user();
    $isInvestor = $authUser && $authUser->role === 'Investor';

    $currentInvestorRelation = null;
    $currentInvestorStatus = null;

    if ($isInvestor && isset($project)) {
        $currentInvestorRelation = $project->investors->firstWhere('id', $authUser->id);
        $currentInvestorStatus = $currentInvestorRelation?->pivot?->status;
    }

    $interestedCount = isset($project)
        ? $project->investors->where('pivot.status', 'interested')->count()
        : 0;

    $interestedUsers = isset($project)
        ? $project->investors->where('pivot.status', 'interested')->take(5)
        : collect();

    $requestedCount = isset($project)
        ? $project->investors->where('pivot.status', 'requested')->count()
        : 0;

    $canViewInvestorDeck = isset($project) && in_array($project->status, [
        'active',
        'published',
        'approved',
        'completed',
        'investor_visible',
    ], true);

    $projectTitle = isset($project)
        ? ($project->name ?? __('frontend.project_show.project_name_missing'))
        : __('frontend.project_show.project_not_found');

    $projectDescription = isset($project)
        ? \Illuminate\Support\Str::limit(strip_tags($project->description ?? __('frontend.project_show.no_description')), 155)
        : __('frontend.project_show.project_not_found_text');

    $projectImage = isset($project) && $project->getFirstMediaUrl('images')
        ? $project->getFirstMediaUrl('images')
        : asset('images/logo.png');
@endphp

@extends('frontend.layouts.app')

@section('title', $projectTitle . ' | ' . config('app.name'))
@section('meta_description', $projectDescription)
@section('canonical', isset($project) ? route('frontend.projects.show', $project) : route('frontend.projects.index'))
@section('og_type', 'article')
@section('og_image', $projectImage)

@section('structured_data')
@if(isset($project))
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CreativeWork',
    'name' => $projectTitle,
    'description' => $projectDescription,
    'url' => route('frontend.projects.show', $project),
    'image' => $projectImage,
    'author' => [
        '@type' => 'Person',
        'name' => $project->student?->name ?? config('app.name'),
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => config('app.name'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('images/logo.png'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endsection

@section('content')
<div class="min-h-screen py-10 sm:py-12 pt-24 sm:pt-28 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

        <div class="project-show-reveal mb-5 sm:mb-6">
            <a href="{{ route('frontend.projects.index') }}" class="inline-flex items-center text-brand-accent hover:underline font-bold text-sm sm:text-base">
                <i class="fas fa-arrow-left me-2 rtl:rotate-180"></i>
                {{ __('frontend.project_show.back_to_projects') }}
            </a>
        </div>

        @if(isset($project))
            @php
                $images = $project->getMedia('images');
                $videoUrl = $project->getFirstMediaUrl('videos');
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">

                <div class="lg:col-span-2 space-y-5 sm:space-y-6 lg:space-y-8 min-w-0">
                    <div class="project-show-card theme-panel p-4 sm:p-6 lg:p-8 rounded-3xl shadow-brand-soft min-w-0">
                        <span class="text-brand-accent font-bold uppercase tracking-widest text-[10px] sm:text-xs break-words">
                            {{ $project->projectCategory?->display_name ?? $project->category ?? __('frontend.project_show.uncategorized') }}
                        </span>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-theme-text mt-2 leading-tight break-words">
                            {{ $project->name ?? __('frontend.project_show.project_name_missing') }}
                        </h1>

                        <div class="mt-6 sm:mt-8">
                            <h3 class="text-theme-text font-bold text-lg sm:text-xl mb-3 sm:mb-4">
                                {{ __('frontend.project_show.description') }}
                            </h3>
                            <p class="text-theme-muted leading-7 sm:leading-relaxed italic text-sm sm:text-base lg:text-lg break-words">
                                "{{ $project->description ?? __('frontend.project_show.no_description') }}"
                            </p>
                        </div>

                        @if($interestedCount > 0)
                            <div class="mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-theme-border">
                                <h3 class="text-theme-text font-bold text-base sm:text-lg mb-4">
                                    {{ __('frontend.project_show.interested_investors') }}
                                </h3>

                                <div class="flex items-center gap-3 flex-wrap">
                                    <div class="flex -space-x-2 rtl:space-x-reverse">
                                        @foreach($interestedUsers as $investor)
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center text-xs sm:text-sm font-black shrink-0">
                                                {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                            </div>
                                        @endforeach
                                    </div>

                                    <span class="text-sm text-theme-muted break-words">
                                        {{ $interestedCount }} {{ trans_choice('frontend.project_show.interested_investor_count', $interestedCount) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="project-show-card theme-panel p-4 sm:p-6 lg:p-8 rounded-3xl shadow-brand-soft min-w-0">
                        <h3 class="text-theme-text font-bold text-lg sm:text-xl mb-5 sm:mb-6">
                            {{ __('frontend.project_show.project_images') }}
                        </h3>

                        @if($images->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                                @foreach($images as $image)
                                    <a href="{{ $image->getUrl() }}" target="_blank" class="project-image-link block rounded-2xl overflow-hidden border border-theme-border hover:border-brand-accent/40 transition">
                                        <img src="{{ $image->getUrl() }}" loading="lazy" alt="{{ __('frontend.project_show.project_image') }}" class="w-full h-44 sm:h-52 object-cover transition duration-500 hover:scale-105">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-theme-muted italic text-sm sm:text-base">{{ __('frontend.project_show.no_images_uploaded') }}</p>
                        @endif
                    </div>

                    <div class="project-show-card theme-panel p-4 sm:p-6 lg:p-8 rounded-3xl shadow-brand-soft min-w-0">
                        <h3 class="text-theme-text font-bold text-lg sm:text-xl mb-5 sm:mb-6">
                            {{ __('frontend.project_show.project_video') }}
                        </h3>

                        @if($videoUrl)
                            <video class="project-video w-full rounded-2xl border border-theme-border bg-black max-h-[320px] sm:max-h-[420px] lg:max-h-[500px]" controls playsinline>
                                <source src="{{ $videoUrl }}">
                                {{ __('frontend.project_show.video_not_supported') }}
                            </video>
                        @else
                            <p class="text-theme-muted italic text-sm sm:text-base">{{ __('frontend.project_show.no_video_uploaded') }}</p>
                        @endif
                    </div>
                </div>

<aside class="vg-project-sidebar min-w-0">
    <div class="project-show-card vg-project-side-card theme-panel p-5 sm:p-6 lg:p-8 rounded-3xl shadow-brand-soft min-w-0">
        <p class="text-theme-muted text-xs uppercase font-bold mb-1">
            {{ __('frontend.project_show.requested_budget') }}
        </p>

        <h2 class="project-budget text-3xl sm:text-4xl font-black text-green-600 break-words">
            ${{ is_numeric($project->budget) ? number_format($project->budget) : '0' }}
        </h2>

        <div class="mt-6 sm:mt-7 pt-6 sm:pt-7 border-t border-theme-border space-y-5">
            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                <span class="text-theme-muted">{{ __('frontend.project_show.student_lead') }}:</span>
                <span class="text-brand-accent font-bold sm:text-end break-words">{{ $project->student?->name ?? __('frontend.project_show.unknown_user') }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                <span class="text-theme-muted">{{ __('frontend.project_show.status') }}:</span>
                <span class="text-yellow-600 font-bold sm:text-end break-words">{{ $project->status ?? 'pending' }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                <span class="text-theme-muted">{{ __('frontend.project_show.interest_count') }}:</span>
                <span class="text-theme-text font-bold sm:text-end">{{ $interestedCount }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                <span class="text-theme-muted">{{ __('frontend.project_show.funding_requests') }}:</span>
                <span class="text-theme-text font-bold sm:text-end">{{ $requestedCount }}</span>
            </div>
        </div>

        @if($isInvestor)
            @if($canViewInvestorDeck)
                <div class="mt-6 space-y-3">
                    <a href="{{ route('investor.projects.summary', $project) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-brand-accent-strong transition text-center">
                        <i class="fas fa-file-lines me-2"></i>
                        {{ __('frontend.project_show.view_summary') }}
                    </a>

                    <a href="{{ route('investor.projects.pitch-deck.download', $project) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-theme-surface-2 text-theme-text font-bold rounded-xl border border-theme-border hover:border-brand-accent hover:text-brand-accent transition text-center">
                        <i class="fas fa-file-powerpoint me-2"></i>
                        {{ __('frontend.project_show.download_powerpoint') }}
                    </a>
                </div>
            @endif

            @if(!$currentInvestorStatus)
                <div class="mt-6 space-y-3">
                    <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-brand-accent-strong transition">
                            {{ __('frontend.project_show.express_investment_interest') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3 funding-form">
                        @csrf
                        <input
                            type="number"
                            name="amount"
                            min="1"
                            step="0.01"
                            placeholder="{{ __('frontend.project_show.funding_amount') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base"
                        >

                        <textarea
                            name="message"
                            rows="4"
                            placeholder="{{ __('frontend.project_show.funding_message_placeholder') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base resize-y"
                        ></textarea>

                        <button type="submit" class="w-full px-4 py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition">
                            {{ __('frontend.project_show.request_funding') }}
                        </button>
                    </form>
                </div>

            @elseif($currentInvestorStatus === 'interested')
                <div class="mt-6 space-y-3">
                    <div class="text-green-600 font-bold text-center p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                        {{ __('frontend.project_show.already_expressed_interest') }}
                    </div>

                    <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-theme-surface-2 text-theme-text font-bold rounded-xl hover:bg-red-500/10 hover:text-red-600 transition border border-theme-border">
                            {{ __('frontend.project_show.remove_interest') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3 funding-form">
                        @csrf
                        <input
                            type="number"
                            name="amount"
                            min="1"
                            step="0.01"
                            placeholder="{{ __('frontend.project_show.funding_amount') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base"
                        >

                        <textarea
                            name="message"
                            rows="4"
                            placeholder="{{ __('frontend.project_show.funding_message_placeholder') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base resize-y"
                        ></textarea>

                        <button type="submit" class="w-full px-4 py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition">
                            {{ __('frontend.project_show.upgrade_to_funding_request') }}
                        </button>
                    </form>
                </div>

            @elseif($currentInvestorStatus === 'requested')
                <div class="mt-6 text-center p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-700 font-bold">
                    {{ __('frontend.project_show.request_under_review') }}
                </div>

            @elseif($currentInvestorStatus === 'approved')
                <div class="mt-6 text-center p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-600 font-bold">
                    {{ __('frontend.project_show.request_approved') }}
                </div>

            @elseif($currentInvestorStatus === 'rejected')
                <div class="mt-6 space-y-3">
                    <div class="text-center p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600 font-bold">
                        {{ __('frontend.project_show.request_rejected') }}
                    </div>

                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3 funding-form">
                        @csrf
                        <input
                            type="number"
                            name="amount"
                            min="1"
                            step="0.01"
                            placeholder="{{ __('frontend.project_show.new_funding_amount') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base"
                        >

                        <textarea
                            name="message"
                            rows="4"
                            placeholder="{{ __('frontend.project_show.new_request_placeholder') }}"
                            class="w-full min-w-0 px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent text-sm sm:text-base resize-y"
                        ></textarea>

                        <button type="submit" class="w-full px-4 py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-brand-accent-strong transition">
                            {{ __('frontend.project_show.submit_new_funding_request') }}
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>

    <div class="project-show-card vg-project-side-card theme-panel p-5 sm:p-6 lg:p-7 rounded-3xl shadow-brand-soft min-w-0">
        <h3 class="text-theme-text font-bold mb-4 flex items-center text-base sm:text-lg">
            <i class="fas fa-file-alt me-2 text-brand-accent"></i>
            {{ __('frontend.project_show.legacy_files') }}
        </h3>

        @if($project->files && $project->files->count() > 0)
            @foreach($project->files as $file)
                <div class="project-file-row flex items-center justify-between gap-4 p-3 bg-theme-surface-2 rounded-xl border border-theme-border mb-2 hover:bg-brand-accent-soft transition-all">
                    <span class="text-theme-text text-sm font-semibold break-words min-w-0">
                        {{ strtoupper($file->file_type ?? __('frontend.project_show.document')) }}
                    </span>
                    <a href="{{ asset('storage/' . ($file->file_path ?? '')) }}" target="_blank" class="text-brand-accent hover:text-theme-text shrink-0">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            @endforeach
        @else
            <p class="text-theme-muted italic text-sm text-center py-4">
                {{ __('frontend.project_show.no_legacy_files') }}
            </p>
        @endif
    </div>
</aside>
            </div>
        @else
            <div class="project-show-reveal bg-red-500/10 border border-red-500/40 p-6 sm:p-10 rounded-3xl text-center">
                <h2 class="text-xl sm:text-2xl text-red-600 font-bold">{{ __('frontend.project_show.project_not_found') }}</h2>
                <p class="text-theme-muted mt-2 text-sm sm:text-base">{{ __('frontend.project_show.project_not_found_text') }}</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-project-show-style')) {
        const style = document.createElement('style');
        style.id = 'vg-project-show-style';
        style.innerHTML = `
            @keyframes projectSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .project-show-reveal,
            .project-show-card {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity .65s ease, transform .65s cubic-bezier(.22,1,.36,1), box-shadow .28s ease;
            }

            .project-show-reveal.is-visible,
            .project-show-card.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .project-image-link,
            .project-file-row {
                transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease, background-color .24s ease;
            }
                .vg-project-sidebar {
    display: flex !important;
    flex-direction: column !important;
    gap: 2rem !important;
    align-items: stretch !important;
}

.vg-project-sidebar > .vg-project-side-card {
    position: relative !important;
    transform: none !important;
    margin: 0 !important;
    width: 100% !important;
    z-index: 1 !important;
}

.vg-project-sidebar > .vg-project-side-card + .vg-project-side-card {
    margin-top: 2rem !important;
}

.vg-project-sidebar .project-show-card:hover {
    transform: none !important;
}

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(0,224,255,.16);
                border-radius: 12px;
            }

            @media (hover: hover) and (pointer: fine) {
                .project-show-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 20px 44px rgba(0,0,0,.09);
                }

                .project-image-link:hover,
                .project-file-row:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 14px 32px rgba(0,0,0,.08);
                }
            }

            @media (max-width: 640px) {
                input,
                button,
                textarea {
                    font-size: 16px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .project-show-reveal,
                .project-show-card,
                .project-image-link,
                .project-file-row {
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
        ...document.querySelectorAll('.project-show-reveal'),
        ...document.querySelectorAll('.project-show-card')
    ].filter(Boolean).forEach((el, index) => {
        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 90));
    });

    if (!prefersReducedMotion) {
        const budgetEl = document.querySelector('.project-budget');

        if (budgetEl) {
            const value = parseInt(budgetEl.textContent.replace(/[^\d]/g, ''), 10);

            if (!Number.isNaN(value)) {
                budgetEl.textContent = '$0';

                const start = performance.now();
                const duration = 1100;

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

    const imageLinks = document.querySelectorAll('.project-image-link');

    if (imageLinks.length) {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div id="projectImagePreviewModal" style="
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.82);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                padding: 16px;
                opacity: 0;
                transition: opacity 0.25s ease;
            ">
        
                <button type="button" id="projectImagePreviewClose" style="
                    position: absolute;
                    top: 18px;
                    right: 18px;
                    width: 46px;
                    height: 46px;
                    border: none;
                    border-radius: 14px;
                    background: rgba(255,255,255,0.12);
                    color: white;
                    font-size: 20px;
                    cursor: pointer;
                ">×</button>
                <img id="projectImagePreviewTarget" src="" alt="Preview" style="
                    max-width: 92vw;
                    max-height: 88vh;
                    border-radius: 20px;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.35);
                    transform: scale(0.96);
                    transition: transform 0.25s ease;
                    object-fit: contain;
                ">
            </div>
        `;
        document.body.appendChild(modal);

        const modalEl = document.getElementById('projectImagePreviewModal');
        const modalImg = document.getElementById('projectImagePreviewTarget');
        const closeBtn = document.getElementById('projectImagePreviewClose');

        imageLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                modalImg.src = link.href;
                modalEl.style.display = 'flex';

                requestAnimationFrame(() => {
                    modalEl.style.opacity = '1';
                    modalImg.style.transform = 'scale(1)';
                });

                document.body.style.overflow = 'hidden';
            });
        });

        function closeModal() {
            modalEl.style.opacity = '0';
            modalImg.style.transform = 'scale(0.96)';

            setTimeout(() => {
                modalEl.style.display = 'none';
                modalImg.src = '';
                document.body.style.overflow = '';
            }, 220);
        }

        closeBtn.addEventListener('click', closeModal);

        modalEl.addEventListener('click', function (e) {
            if (e.target === modalEl) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modalEl.style.display === 'flex') {
                closeModal();
            }
        });
    }

    const video = document.querySelector('.project-video');

    if (video) {
        video.addEventListener('play', function () {
            video.style.boxShadow = '0 20px 45px rgba(0,0,0,0.18)';
            video.style.transform = 'scale(1.003)';
            video.style.transition = 'transform 0.25s ease, box-shadow 0.25s ease';
        });

        video.addEventListener('pause', function () {
            video.style.boxShadow = '';
            video.style.transform = '';
        });

        video.addEventListener('ended', function () {
            video.style.boxShadow = '';
            video.style.transform = '';
        });
    }

    document.querySelectorAll('.funding-form').forEach(form => {
        const amountInput = form.querySelector('input[name="amount"]');
        const messageInput = form.querySelector('textarea[name="message"]');
        const submitBtn = form.querySelector('button[type="submit"]');

        if (amountInput) {
            const hint = document.createElement('div');
            hint.className = 'text-xs mt-2';
            hint.style.minHeight = '18px';
            amountInput.insertAdjacentElement('afterend', hint);

            function updateAmountHint() {
                const value = parseFloat(amountInput.value);

                if (!amountInput.value.trim()) {
                    hint.textContent = '';
                    hint.className = 'text-xs mt-2';
                    amountInput.style.borderColor = '';
                    return;
                }

                if (Number.isNaN(value) || value <= 0) {
                    hint.textContent = 'Please enter a valid funding amount.';
                    hint.className = 'text-xs mt-2 text-red-500';
                    amountInput.style.borderColor = 'rgb(239 68 68)';
                } else {
                    hint.textContent = 'Amount looks good.';
                    hint.className = 'text-xs mt-2 text-green-600';
                    amountInput.style.borderColor = 'rgb(34 197 94)';
                }
            }

            amountInput.addEventListener('input', updateAmountHint);
            amountInput.addEventListener('blur', updateAmountHint);
        }

        if (messageInput) {
            const counter = document.createElement('div');
            counter.className = 'text-xs text-theme-muted mt-2 text-end';
            messageInput.insertAdjacentElement('afterend', counter);

            function updateCounter() {
                const length = messageInput.value.length;
                counter.textContent = `${length} characters`;

                if (length > 500) {
                    counter.className = 'text-xs mt-2 text-end text-red-500';
                } else if (length > 300) {
                    counter.className = 'text-xs mt-2 text-end text-yellow-500';
                } else {
                    counter.className = 'text-xs text-theme-muted mt-2 text-end';
                }
            }

            updateCounter();
            messageInput.addEventListener('input', updateCounter);
        }

        form.addEventListener('submit', function () {
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.9';
            submitBtn.innerHTML = `
                <span style="display:inline-flex;align-items:center;justify-content:center;gap:10px;">
                    <span style="
                        width:16px;
                        height:16px;
                        border:2px solid rgba(255,255,255,0.45);
                        border-top-color:white;
                        border-radius:50%;
                        display:inline-block;
                        animation: projectSpin .7s linear infinite;
                    "></span>
                    Processing...
                </span>
            `;
        });
    });

    document.querySelectorAll('form').forEach(form => {
        if (form.classList.contains('funding-form')) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.9';

            submitBtn.innerHTML = `
                <span style="display:inline-flex;align-items:center;justify-content:center;gap:10px;">
                    <span style="
                        width:16px;
                        height:16px;
                        border:2px solid rgba(255,255,255,0.45);
                        border-top-color:currentColor;
                        border-radius:50%;
                        display:inline-block;
                        animation: projectSpin .7s linear infinite;
                    "></span>
                    Loading...
                </span>
            `;
        });
    });

    document.querySelectorAll('a, button, input, textarea').forEach(item => {
        item.classList.add('vg-focus-ring');
    });
});
</script>
@endsection