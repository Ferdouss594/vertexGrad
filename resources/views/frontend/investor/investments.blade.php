@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="{{ config('design.classes.container') }}">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-theme-text">
                    {{ __('frontend.investments.my') }} <span class="text-brand-accent">{{ __('frontend.investments.investments') }}</span>
                </h1>
                <p class="text-theme-muted mt-2">
                    {{ __('frontend.investments.subtitle') }}
                </p>
            </div>
        </div>

        <div class="theme-panel rounded-3xl overflow-hidden shadow-brand-soft">
            @if($projects->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-theme-surface-2 border-b border-theme-border">
                            <tr>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.project') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.student') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.status') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.amount') }}</th>
                                <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-widest text-theme-muted">{{ __('frontend.investments.date') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($projects as $project)
                                @php
                                    $status = strtolower($project->pivot->status ?? 'interested');
                                    $statusClasses = match($status) {
                                        'approved' => 'bg-green-500/10 text-green-600 border-green-500/20',
                                        'requested' => 'bg-yellow-500/10 text-yellow-700 border-yellow-500/20',
                                        'rejected' => 'bg-red-500/10 text-red-600 border-red-500/20',
                                        default => 'bg-brand-accent-soft text-brand-accent border-brand-accent/20',
                                    };
                                @endphp

                                <tr class="border-b border-theme-border last:border-b-0">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('frontend.projects.show', $project) }}"
                                           class="font-bold text-theme-text hover:text-brand-accent transition">
                                            {{ $project->name }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-5 text-theme-muted">
                                        {{ $project->student->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-[11px] font-black uppercase tracking-widest border {{ $statusClasses }}">
                                            {{ ucfirst($project->pivot->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 font-bold text-theme-text">
                                        ${{ number_format($project->pivot->amount ?? 0) }}
                                    </td>

                                    <td class="px-6 py-5 text-theme-muted">
                                        {{ $project->pivot->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-brand-accent-soft text-brand-accent flex items-center justify-center mb-4">
                        <i class="fas fa-briefcase text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-theme-text mb-2">{{ __('frontend.investments.no_investments_yet') }}</h3>
                    <p class="text-theme-muted mb-6">{{ __('frontend.investments.no_investments_text') }}</p>
                    <a href="{{ route('frontend.projects.index') }}"
                       class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                        {{ __('frontend.investments.explore_projects') }}
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-investments-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-investments-motion-style';
        style.innerHTML = `
            @keyframes vgSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .vg-progress-line {
                position: fixed;
                top: 0;
                left: 0;
                height: 3px;
                width: 0%;
                z-index: 9999;
                pointer-events: none;
                background: linear-gradient(90deg, rgba(99,102,241,0.98), rgba(34,197,94,0.98));
                box-shadow: 0 0 18px rgba(99,102,241,0.28);
                transition: width 0.08s linear;
            }

            .vg-scroll-hint {
                animation: vgScrollHintFloat 1.8s ease-in-out infinite;
            }

            @keyframes vgScrollHintFloat {
                0%, 100% { transform: translateX(0); }
                50% { transform: translateX(6px); }
            }
        `;
        document.head.appendChild(style);
    }

    // =====================================
    // Reading progress
    // =====================================
    const progress = document.createElement('div');
    progress.className = 'vg-progress-line';
    document.body.appendChild(progress);

    function updateProgress() {
        const scrollTop = window.scrollY || window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const percent = docHeight > 0 ? Math.min((scrollTop / docHeight) * 100, 100) : 0;
        progress.style.width = percent + '%';
    }

    updateProgress();
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);

    // =====================================
    // Core elements
    // =====================================
    const pageHeader = document.querySelector('.flex.flex-col.md\\:flex-row.md\\:items-center.md\\:justify-between.gap-4.mb-8');
    const title = document.querySelector('h1');
    const panel = document.querySelector('.theme-panel');
    const tableWrap = document.querySelector('.overflow-x-auto');
    const table = document.querySelector('table');
    const tableHead = document.querySelector('thead');
    const rows = Array.from(document.querySelectorAll('tbody tr'));
    const emptyState = document.querySelector('.p-12.text-center');
    const emptyButton = emptyState ? emptyState.querySelector('a[href]') : null;

    // =====================================
    // Calm premium entrance
    // =====================================
    if (!prefersReducedMotion) {
        if (pageHeader) {
            pageHeader.style.opacity = '0';
            pageHeader.style.transform = 'translateY(34px)';
            pageHeader.style.transition = 'opacity 1.05s ease, transform 1.05s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                pageHeader.style.opacity = '1';
                pageHeader.style.transform = 'translateY(0)';
            }, 120);
        }

        if (panel) {
            panel.style.opacity = '0';
            panel.style.transform = 'translateY(36px)';
            panel.style.transition = 'opacity 1.08s ease, transform 1.08s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                panel.style.opacity = '1';
                panel.style.transform = 'translateY(0)';
            }, 420);
        }

        if (tableHead) {
            tableHead.style.opacity = '0';
            tableHead.style.transform = 'translateY(18px)';
            tableHead.style.transition = 'opacity 0.9s ease, transform 0.9s ease';
            setTimeout(() => {
                tableHead.style.opacity = '1';
                tableHead.style.transform = 'translateY(0)';
            }, 760);
        }

        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(22px)';
            row.style.transition = 'opacity 0.85s ease, transform 0.85s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 920 + (index * 120));
        });

        if (emptyState) {
            emptyState.style.opacity = '0';
            emptyState.style.transform = 'translateY(28px)';
            emptyState.style.transition = 'opacity 1s ease, transform 1s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                emptyState.style.opacity = '1';
                emptyState.style.transform = 'translateY(0)';
            }, 780);
        }
    }

    // =====================================
    // Table row hover polish
    // =====================================
    rows.forEach(row => {
        row.style.transition = 'background-color 0.25s ease, transform 0.25s ease';

        row.addEventListener('mouseenter', function () {
            if (prefersReducedMotion) return;
            row.style.transform = 'translateX(4px)';
            row.style.backgroundColor = 'rgba(99, 102, 241, 0.04)';
        });

        row.addEventListener('mouseleave', function () {
            row.style.transform = '';
            row.style.backgroundColor = '';
        });
    });

    // =====================================
    // Panel hover polish
    // =====================================
    if (panel) {
        panel.style.transition = 'transform 0.32s ease, box-shadow 0.32s ease';

        panel.addEventListener('mouseenter', function () {
            if (prefersReducedMotion) return;
            panel.style.transform = 'translateY(-5px)';
            panel.style.boxShadow = '0 22px 48px rgba(0,0,0,0.09)';
        });

        panel.addEventListener('mouseleave', function () {
            panel.style.transform = 'translateY(0)';
            panel.style.boxShadow = '';
        });
    }

    // =====================================
    // Amount count-up animation
    // =====================================
    function animateValue(el, finalValue, prefix = '$', duration = 1500) {
        const startTime = performance.now();

        function update(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(finalValue * eased);
            el.textContent = prefix + currentValue.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = prefix + finalValue.toLocaleString();
            }
        }

        requestAnimationFrame(update);
    }

    if (!prefersReducedMotion) {
        const amountCells = Array.from(document.querySelectorAll('tbody td.font-bold.text-theme-text')).filter(cell => {
            return /^\$\d[\d,]*$/.test(cell.textContent.trim());
        });

        amountCells.forEach((cell, index) => {
            const value = parseInt(cell.textContent.replace(/[^\d]/g, ''), 10);
            if (isNaN(value)) return;

            cell.textContent = '$0';

            setTimeout(() => {
                animateValue(cell, value, '$', 1600);
            }, 1100 + (index * 120));
        });
    }

    // =====================================
    // Project link polish
    // =====================================
    const projectLinks = document.querySelectorAll('tbody a[href]');
    projectLinks.forEach(link => {
        link.style.transition = 'color 0.25s ease, transform 0.25s ease';

        link.addEventListener('mouseenter', function () {
            if (prefersReducedMotion) return;
            link.style.transform = 'translateX(2px)';
        });

        link.addEventListener('mouseleave', function () {
            link.style.transform = '';
        });
    });

    // =====================================
    // Mobile horizontal scroll hint
    // =====================================
    if (tableWrap && window.innerWidth < 768) {
        const hint = document.createElement('div');
        hint.className = 'vg-scroll-hint text-xs text-theme-muted px-4 pt-4';
        hint.innerHTML = `
            <span style="display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-arrow-right text-brand-accent"></i>
                Scroll horizontally to view full table
            </span>
        `;

        tableWrap.parentNode.insertBefore(hint, tableWrap);

        function hideHintWhenScrolled() {
            if (tableWrap.scrollLeft > 10) {
                hint.style.opacity = '0';
                hint.style.transition = 'opacity 0.35s ease';
            }
        }

        tableWrap.addEventListener('scroll', hideHintWhenScrolled, { passive: true });
    }

    // =====================================
    // Empty state CTA feedback
    // =====================================
    if (emptyButton) {
        const originalHTML = emptyButton.innerHTML;

        emptyButton.addEventListener('click', function () {
            emptyButton.style.pointerEvents = 'none';
            emptyButton.style.opacity = '0.92';
            emptyButton.innerHTML = `
                <span style="display:inline-flex;align-items:center;gap:10px;">
                    <span style="
                        width:16px;
                        height:16px;
                        border:2px solid rgba(255,255,255,0.45);
                        border-top-color:#ffffff;
                        border-radius:50%;
                        display:inline-block;
                        animation: vgSpin .7s linear infinite;
                    "></span>
                    Opening...
                </span>
            `;

            setTimeout(() => {
                emptyButton.style.pointerEvents = '';
                emptyButton.style.opacity = '';
                emptyButton.innerHTML = originalHTML;
            }, 1800);
        });
    }

    // =====================================
    // Accessibility focus polish
    // =====================================
    const interactive = document.querySelectorAll('a, button');
    interactive.forEach(el => {
        el.addEventListener('focus', function () {
            el.style.outline = 'none';
            el.style.boxShadow = '0 0 0 3px rgba(99,102,241,0.18)';
        });

        el.addEventListener('blur', function () {
            el.style.boxShadow = '';
        });
    });
});
</script>
@endsection