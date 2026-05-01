@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 sm:py-14 lg:py-16 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="w-full p-4 sm:p-6 md:p-8 lg:p-10 rounded-3xl sm:rounded-[2rem] theme-panel shadow-brand-soft">

            <div class="mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-theme-text mb-2 break-words">
                    {{ __('frontend.submit_step2.step_title') }}
                </h3>
                <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                    <div class="h-full bg-brand-accent" style="width: 40%;"></div>
                </div>
            </div>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-theme-text mb-2 leading-tight break-words">
                {{ __('frontend.submit_step2.page_title') }}
            </h2>

            <p class="text-sm sm:text-base md:text-lg text-theme-muted mb-6 sm:mb-8 lg:mb-10 leading-6 sm:leading-7">
                {{ __('frontend.submit_step2.page_subtitle') }}
            </p>

            @if ($errors->any())
                <div class="mb-5 sm:mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="break-words">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('project.submit.step2.post') }}" method="POST" class="space-y-5 sm:space-y-6 lg:space-y-8">
                @csrf

                <div class="border border-theme-border p-4 sm:p-5 md:p-6 rounded-2xl bg-theme-surface-2 min-w-0">
                    <h4 class="text-xl sm:text-2xl font-semibold text-brand-accent mb-4 break-words">
                        {{ __('frontend.submit_step2.student_information') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="min-w-0">
                            <label for="student_name" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.student_full_name') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="student_name"
                                name="student_name"
                                required
                                value="{{ old('student_name', session('project_data.student_name')) }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="academic_level" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.academic_level') }} <span class="text-brand-accent">*</span>
                            </label>
                            <select
                                id="academic_level"
                                name="academic_level"
                                required
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                                <option value="" disabled {{ old('academic_level', session('project_data.academic_level')) ? '' : 'selected' }}>
                                    {{ __('frontend.submit_step2.select_academic_level') }}
                                </option>
                                <option value="diploma" {{ old('academic_level', session('project_data.academic_level')) == 'diploma' ? 'selected' : '' }}>{{ __('frontend.submit_step2.level_diploma') }}</option>
                                <option value="bachelor" {{ old('academic_level', session('project_data.academic_level')) == 'bachelor' ? 'selected' : '' }}>{{ __('frontend.submit_step2.level_bachelor') }}</option>
                                <option value="master" {{ old('academic_level', session('project_data.academic_level')) == 'master' ? 'selected' : '' }}>{{ __('frontend.submit_step2.level_master') }}</option>
                                <option value="phd" {{ old('academic_level', session('project_data.academic_level')) == 'phd' ? 'selected' : '' }}>{{ __('frontend.submit_step2.level_phd') }}</option>
                                <option value="independent_research" {{ old('academic_level', session('project_data.academic_level')) == 'independent_research' ? 'selected' : '' }}>{{ __('frontend.submit_step2.level_independent_research') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border border-theme-border p-4 sm:p-5 md:p-6 rounded-2xl bg-theme-surface-2 min-w-0">
                    <h4 class="text-xl sm:text-2xl font-semibold text-brand-accent mb-4 break-words">
                        {{ __('frontend.submit_step2.supervisor_information') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="min-w-0">
                            <label for="supervisor_name" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.supervisor_name') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="supervisor_name"
                                name="supervisor_name"
                                required
                                value="{{ old('supervisor_name', session('project_data.supervisor_name')) }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="supervisor_title" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.supervisor_title') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="supervisor_title"
                                name="supervisor_title"
                                required
                                value="{{ old('supervisor_title', session('project_data.supervisor_title')) }}"
                                placeholder="{{ __('frontend.submit_step2.supervisor_title_placeholder') }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>
                    </div>
                </div>

                <div class="border border-theme-border p-4 sm:p-5 md:p-6 rounded-2xl bg-theme-surface-2 min-w-0">
                    <h4 class="text-xl sm:text-2xl font-semibold text-brand-accent mb-4 break-words">
                        {{ __('frontend.submit_step2.institution_information') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="min-w-0">
                            <label for="university_name" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.university_name') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="university_name"
                                name="university_name"
                                required
                                value="{{ old('university_name', session('project_data.university_name')) }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="college_name" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.college_name') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="college_name"
                                name="college_name"
                                required
                                value="{{ old('college_name', session('project_data.college_name')) }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="department" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.department') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="text"
                                id="department"
                                name="department"
                                required
                                value="{{ old('department', session('project_data.department')) }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="governorate" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step2.governorate') }} <span class="text-brand-accent">*</span>
                            </label>
                            <select
                                id="governorate"
                                name="governorate"
                                required
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                                <option value="" disabled {{ old('governorate', session('project_data.governorate')) ? '' : 'selected' }}>
                                    {{ __('frontend.submit_step2.select_governorate') }}
                                </option>
                                <option value="sanaa" {{ old('governorate', session('project_data.governorate')) == 'sanaa' ? 'selected' : '' }}>{{ __('frontend.governorates.sanaa') }}</option>
                                <option value="aden" {{ old('governorate', session('project_data.governorate')) == 'aden' ? 'selected' : '' }}>{{ __('frontend.governorates.aden') }}</option>
                                <option value="taiz" {{ old('governorate', session('project_data.governorate')) == 'taiz' ? 'selected' : '' }}>{{ __('frontend.governorates.taiz') }}</option>
                                <option value="ibb" {{ old('governorate', session('project_data.governorate')) == 'ibb' ? 'selected' : '' }}>{{ __('frontend.governorates.ibb') }}</option>
                                <option value="hodeidah" {{ old('governorate', session('project_data.governorate')) == 'hodeidah' ? 'selected' : '' }}>{{ __('frontend.governorates.hodeidah') }}</option>
                                <option value="hadramout" {{ old('governorate', session('project_data.governorate')) == 'hadramout' ? 'selected' : '' }}>{{ __('frontend.governorates.hadramout') }}</option>
                                <option value="dhamar" {{ old('governorate', session('project_data.governorate')) == 'dhamar' ? 'selected' : '' }}>{{ __('frontend.governorates.dhamar') }}</option>
                                <option value="marib" {{ old('governorate', session('project_data.governorate')) == 'marib' ? 'selected' : '' }}>{{ __('frontend.governorates.marib') }}</option>
                                <option value="amran" {{ old('governorate', session('project_data.governorate')) == 'amran' ? 'selected' : '' }}>{{ __('frontend.governorates.amran') }}</option>
                                <option value="hajjah" {{ old('governorate', session('project_data.governorate')) == 'hajjah' ? 'selected' : '' }}>{{ __('frontend.governorates.hajjah') }}</option>
                                <option value="lahij" {{ old('governorate', session('project_data.governorate')) == 'lahij' ? 'selected' : '' }}>{{ __('frontend.governorates.lahij') }}</option>
                                <option value="shabwah" {{ old('governorate', session('project_data.governorate')) == 'shabwah' ? 'selected' : '' }}>{{ __('frontend.governorates.shabwah') }}</option>
                                <option value="abyan" {{ old('governorate', session('project_data.governorate')) == 'abyan' ? 'selected' : '' }}>{{ __('frontend.governorates.abyan') }}</option>
                                <option value="saada" {{ old('governorate', session('project_data.governorate')) == 'saada' ? 'selected' : '' }}>{{ __('frontend.governorates.saada') }}</option>
                                <option value="aljawf" {{ old('governorate', session('project_data.governorate')) == 'aljawf' ? 'selected' : '' }}>{{ __('frontend.governorates.aljawf') }}</option>
                                <option value="almahwit" {{ old('governorate', session('project_data.governorate')) == 'almahwit' ? 'selected' : '' }}>{{ __('frontend.governorates.almahwit') }}</option>
                                <option value="raymah" {{ old('governorate', session('project_data.governorate')) == 'raymah' ? 'selected' : '' }}>{{ __('frontend.governorates.raymah') }}</option>
                                <option value="albayda" {{ old('governorate', session('project_data.governorate')) == 'albayda' ? 'selected' : '' }}>{{ __('frontend.governorates.albayda') }}</option>
                                <option value="aldhale" {{ old('governorate', session('project_data.governorate')) == 'aldhale' ? 'selected' : '' }}>{{ __('frontend.governorates.aldhale') }}</option>
                                <option value="almahrah" {{ old('governorate', session('project_data.governorate')) == 'almahrah' ? 'selected' : '' }}>{{ __('frontend.governorates.almahrah') }}</option>
                                <option value="socotra" {{ old('governorate', session('project_data.governorate')) == 'socotra' ? 'selected' : '' }}>{{ __('frontend.governorates.socotra') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-4 pt-2 sm:pt-4">
                    <a
                        href="{{ route('project.submit.step1') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-8 py-3 text-base sm:text-lg font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300 text-center"
                    >
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('frontend.common.back') }}
                    </a>

                    <button
                        type="submit"
                        class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-8 py-3 text-base sm:text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft text-center"
                    >
                        {{ __('frontend.common.save_continue') }} <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const pagePanel = document.querySelector('.theme-panel');
    const progressLabel = document.querySelector('.mb-6 h3, .mb-8 h3');
    const progressBar = document.querySelector('.mb-6 .bg-brand-accent, .mb-8 .bg-brand-accent');
    const heading = document.querySelector('h2');
    const subtitle = document.querySelector('h2 + p');
    const errorBox = document.querySelector('.bg-red-500\\/10');
    const form = document.querySelector('form');
    const cards = Array.from(document.querySelectorAll('form .border.border-theme-border'));
    const fields = Array.from(document.querySelectorAll('input, select'));
    const backLink = form?.querySelector('a[href*="step1"]');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-submit-step2-style')) {
        const style = document.createElement('style');
        style.id = 'vg-submit-step2-style';
        style.textContent = `
            .vg-reveal {
                opacity: 0;
                transform: translateY(16px);
                transition: opacity .6s ease, transform .6s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .vg-card {
                transition: box-shadow .22s ease, border-color .22s ease;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-card:hover {
                    box-shadow: 0 16px 36px rgba(0,0,0,.05);
                    border-color: rgba(99,102,241,.14);
                }

                .vg-btn:hover,
                .vg-back-link:hover {
                    transform: translateY(-1px);
                }
            }

            .vg-field {
                max-width: 100%;
                transition: border-color .2s ease, box-shadow .2s ease;
            }

            .vg-field:focus {
                box-shadow: 0 0 0 4px rgba(99,102,241,.10);
            }

            .vg-field.is-complete {
                border-color: rgba(34,197,94,.42);
            }

            .vg-btn,
            .vg-back-link {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .vg-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,.16);
                border-radius: 12px;
            }

            @media (max-width: 640px) {
                .vg-reveal {
                    transform: translateY(12px);
                }

                input,
                button,
                select,
                textarea {
                    font-size: 16px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-card,
                .vg-field,
                .vg-btn,
                .vg-back-link {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [pagePanel, progressLabel, heading, subtitle, errorBox, ...cards].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (cards.includes(el)) {
            el.classList.add('vg-card');
        }

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 70 + (index * 85));
    });

    if (progressBar && !prefersReducedMotion) {
        progressBar.style.width = '0%';
        progressBar.style.transition = 'width .9s cubic-bezier(.22,1,.36,1)';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progressBar.style.width = '40%';
            });
        });
    }

    fields.forEach((field, index) => {
        field.classList.add('vg-field', 'vg-focus-ring');

        const syncState = () => {
            const value = (field.value || '').trim();
            field.classList.toggle('is-complete', value.length > 0);
        };

        syncState();
        field.addEventListener('input', syncState);
        field.addEventListener('change', syncState);

        if (!prefersReducedMotion) {
            field.style.opacity = '0';
            field.style.transform = 'translateY(10px)';
            field.style.transition = `${field.style.transition || ''}, opacity .45s ease, transform .45s ease`;

            setTimeout(() => {
                field.style.opacity = '1';
                field.style.transform = 'translateY(0)';
            }, 170 + (index * 40));
        }
    });

    if (backLink) {
        backLink.classList.add('vg-back-link', 'vg-focus-ring');
    }

    if (submitButton) {
        submitButton.classList.add('vg-btn', 'vg-focus-ring');

        form?.addEventListener('submit', () => {
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center justify-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('frontend.common.save_continue') }}
                </span>
            `;
        });
    }
});
</script>
@endsection