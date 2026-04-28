<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2"><?php echo e(__('frontend.submit_step1.step_title')); ?></h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 20%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2"><?php echo e(__('frontend.submit_step1.page_title')); ?></h2>
        <p class="text-lg text-theme-muted mb-10">
            <?php echo e(__('frontend.submit_step1.page_subtitle')); ?>

        </p>

        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('project.submit.step1.post')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>

            <div>
                <label for="project_title" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.project_title')); ?> <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="project_title"
                    name="project_title"
                    required
                    value="<?php echo e(old('project_title', session('project_data.project_title'))); ?>"
                    placeholder="<?php echo e(__('frontend.submit_step1.project_title_placeholder')); ?>"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="abstract" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.project_summary')); ?> <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="abstract"
                    name="abstract"
                    required
                    rows="6"
                    placeholder="<?php echo e(__('frontend.submit_step1.project_summary_placeholder')); ?>"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                ><?php echo e(old('abstract', session('project_data.abstract'))); ?></textarea>
            </div>

            <div>
                <label for="discipline" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.primary_discipline')); ?> <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="discipline"
                    name="discipline"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled <?php echo e(old('discipline', session('project_data.discipline')) ? '' : 'selected'); ?>>
                        <?php echo e(__('frontend.submit_step1.select_discipline')); ?>

                    </option>
                    <option value="it" <?php echo e(old('discipline', session('project_data.discipline')) == 'it' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_it')); ?></option>
                    <option value="software" <?php echo e(old('discipline', session('project_data.discipline')) == 'software' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_software')); ?></option>
                    <option value="ai_ml" <?php echo e(old('discipline', session('project_data.discipline')) == 'ai_ml' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_ai_ml')); ?></option>
                    <option value="medical" <?php echo e(old('discipline', session('project_data.discipline')) == 'medical' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_medical')); ?></option>
                    <option value="electrical" <?php echo e(old('discipline', session('project_data.discipline')) == 'electrical' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_electrical')); ?></option>
                    <option value="energy" <?php echo e(old('discipline', session('project_data.discipline')) == 'energy' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_energy')); ?></option>
                    <option value="agriculture" <?php echo e(old('discipline', session('project_data.discipline')) == 'agriculture' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_agriculture')); ?></option>
                    <option value="education" <?php echo e(old('discipline', session('project_data.discipline')) == 'education' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_education')); ?></option>
                    <option value="business" <?php echo e(old('discipline', session('project_data.discipline')) == 'business' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.discipline_business')); ?></option>
                    <option value="other" <?php echo e(old('discipline', session('project_data.discipline')) == 'other' ? 'selected' : ''); ?>><?php echo e(__('frontend.common.other')); ?></option>
                </select>
            </div>

            <div>
                <label for="project_type" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.project_type')); ?> <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_type"
                    name="project_type"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled <?php echo e(old('project_type', session('project_data.project_type')) ? '' : 'selected'); ?>>
                        <?php echo e(__('frontend.submit_step1.select_project_type')); ?>

                    </option>
                    <option value="graduation_project" <?php echo e(old('project_type', session('project_data.project_type')) == 'graduation_project' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_graduation_project')); ?></option>
                    <option value="research" <?php echo e(old('project_type', session('project_data.project_type')) == 'research' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_research')); ?></option>
                    <option value="innovation" <?php echo e(old('project_type', session('project_data.project_type')) == 'innovation' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_innovation')); ?></option>
                    <option value="application" <?php echo e(old('project_type', session('project_data.project_type')) == 'application' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_application')); ?></option>
                    <option value="platform" <?php echo e(old('project_type', session('project_data.project_type')) == 'platform' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_platform')); ?></option>
                    <option value="system" <?php echo e(old('project_type', session('project_data.project_type')) == 'system' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_system')); ?></option>
                    <option value="prototype" <?php echo e(old('project_type', session('project_data.project_type')) == 'prototype' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.type_prototype')); ?></option>
                    <option value="other" <?php echo e(old('project_type', session('project_data.project_type')) == 'other' ? 'selected' : ''); ?>><?php echo e(__('frontend.common.other')); ?></option>
                </select>
            </div>

            <div>
                <label for="problem_statement" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.problem_statement')); ?> <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="problem_statement"
                    name="problem_statement"
                    required
                    rows="4"
                    placeholder="<?php echo e(__('frontend.submit_step1.problem_statement_placeholder')); ?>"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                ><?php echo e(old('problem_statement', session('project_data.problem_statement'))); ?></textarea>
            </div>

            <div>
                <label for="target_beneficiaries" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.target_beneficiaries')); ?> <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="target_beneficiaries"
                    name="target_beneficiaries"
                    required
                    value="<?php echo e(old('target_beneficiaries', session('project_data.target_beneficiaries'))); ?>"
                    placeholder="<?php echo e(__('frontend.submit_step1.target_beneficiaries_placeholder')); ?>"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="project_nature" class="block text-sm font-medium text-theme-muted mb-2">
                    <?php echo e(__('frontend.submit_step1.project_nature')); ?> <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_nature"
                    name="project_nature"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled <?php echo e(old('project_nature', session('project_data.project_nature')) ? '' : 'selected'); ?>>
                        <?php echo e(__('frontend.submit_step1.select_project_nature')); ?>

                    </option>
                    <option value="theoretical" <?php echo e(old('project_nature', session('project_data.project_nature')) == 'theoretical' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.nature_theoretical')); ?></option>
                    <option value="practical" <?php echo e(old('project_nature', session('project_data.project_nature')) == 'practical' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.nature_practical')); ?></option>
                    <option value="research_practical" <?php echo e(old('project_nature', session('project_data.project_nature')) == 'research_practical' ? 'selected' : ''); ?>><?php echo e(__('frontend.submit_step1.nature_research_practical')); ?></option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                >
                    <?php echo e(__('frontend.common.save_continue')); ?> <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const pagePanel = document.querySelector('.theme-panel');
    const progressLabel = document.querySelector('.mb-8 h3');
    const progressBar = document.querySelector('.mb-8 .bg-brand-accent');
    const heading = document.querySelector('h2');
    const subtitle = document.querySelector('h2 + p');
    const errorBox = document.querySelector('.bg-red-500\\/10');
    const form = document.querySelector('form');
    const fields = Array.from(document.querySelectorAll('input, textarea, select'));
    const summaryField = document.getElementById('abstract');
    const problemField = document.getElementById('problem_statement');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-submit-step1-style')) {
        const style = document.createElement('style');
        style.id = 'vg-submit-step1-style';
        style.textContent = `
            .vg-reveal {
                opacity: 0;
                transform: translateY(18px);
                transition: opacity .65s ease, transform .65s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .vg-field {
                transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
            }

            .vg-field:focus {
                box-shadow: 0 0 0 4px rgba(99,102,241,.10);
            }

            .vg-field.is-complete {
                border-color: rgba(34,197,94,.42);
            }

            .vg-counter {
                margin-top: 8px;
                font-size: 12px;
                color: var(--theme-muted, #6b7280);
                text-align: right;
            }

            .vg-submit-btn {
                transition: transform .22s ease, box-shadow .22s ease, opacity .22s ease;
            }

            .vg-submit-btn:hover {
                transform: translateY(-1px);
            }

            .vg-submit-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,.16);
                border-radius: 12px;
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-field,
                .vg-submit-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [pagePanel, progressLabel, heading, subtitle, errorBox, form].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 90 + (index * 100));
    });

    if (progressBar && !prefersReducedMotion) {
        progressBar.style.width = '0%';
        progressBar.style.transition = 'width .85s cubic-bezier(.22,1,.36,1)';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progressBar.style.width = '20%';
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
            field.style.transition += ', opacity .45s ease, transform .45s ease';

            setTimeout(() => {
                field.style.opacity = '1';
                field.style.transform = 'translateY(0)';
            }, 220 + (index * 55));
        }
    });

    function addCounter(textarea, minGood = 80) {
        if (!textarea) return;

        const counter = document.createElement('div');
        counter.className = 'vg-counter';
        textarea.insertAdjacentElement('afterend', counter);

        const updateCounter = () => {
            const len = textarea.value.trim().length;
            counter.textContent = `${len} characters`;
            counter.style.color = len >= minGood ? '' : '';
        };

        updateCounter();
        textarea.addEventListener('input', updateCounter);
    }

    addCounter(summaryField, 120);
    addCounter(problemField, 80);

    if (submitButton) {
        submitButton.classList.add('vg-submit-btn', 'vg-focus-ring');

        form?.addEventListener('submit', () => {
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    <?php echo e(__('frontend.common.save_continue')); ?>

                </span>
            `;
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/frontend/submissions/step1.blade.php ENDPATH**/ ?>