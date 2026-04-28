<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                <?php echo e(__('frontend.contact.title_before')); ?>

                <span class="text-brand-accent"><?php echo e(__('frontend.contact.title_highlight')); ?></span>
            </h1>
            <p class="text-xl text-theme-muted max-w-xl mx-auto">
                <?php echo e(__('frontend.contact.subtitle')); ?>

            </p>
        </header>

        <div class="theme-panel p-10 rounded-2xl">

            <?php if(session('success')): ?>
                <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-600">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-600">
                    <p class="font-semibold mb-2"><?php echo e(__('frontend.contact.fix_issues')); ?></p>
                    <ul class="list-disc pl-5 space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('utility.contact.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-theme-muted mb-2">
                            <?php echo e(__('frontend.contact.name')); ?>

                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php echo e(old('name', auth('web')->check() ? auth('web')->user()->name : '')); ?>"
                            required
                            maxlength="100"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                            placeholder="<?php echo e(__('frontend.contact.name_placeholder')); ?>"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-theme-muted mb-2">
                            <?php echo e(__('frontend.contact.email')); ?>

                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo e(old('email', auth('web')->check() ? auth('web')->user()->email : '')); ?>"
                            required
                            maxlength="150"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                            placeholder="<?php echo e(__('frontend.contact.email_placeholder')); ?>"
                        >
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-theme-muted mb-2">
                        <?php echo e(__('frontend.contact.subject')); ?>

                    </label>
                    <select
                        id="subject"
                        name="subject"
                        required
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                    >
                        <option value="" disabled <?php echo e(old('subject') ? '' : 'selected'); ?>>
                            <?php echo e(__('frontend.contact.subject_placeholder')); ?>

                        </option>
                        <option value="academic" <?php echo e(old('subject') === 'academic' ? 'selected' : ''); ?>>
                            <?php echo e(__('frontend.contact.subject_academic')); ?>

                        </option>
                        <option value="investor" <?php echo e(old('subject') === 'investor' ? 'selected' : ''); ?>>
                            <?php echo e(__('frontend.contact.subject_investor')); ?>

                        </option>
                        <option value="support" <?php echo e(old('subject') === 'support' ? 'selected' : ''); ?>>
                            <?php echo e(__('frontend.contact.subject_support')); ?>

                        </option>
                        <option value="other" <?php echo e(old('subject') === 'other' ? 'selected' : ''); ?>>
                            <?php echo e(__('frontend.contact.subject_other')); ?>

                        </option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-theme-muted mb-2">
                        <?php echo e(__('frontend.contact.message')); ?>

                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        maxlength="5000"
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                        placeholder="<?php echo e(__('frontend.contact.message_placeholder')); ?>"
                    ><?php echo e(old('message')); ?></textarea>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <?php echo e(__('frontend.contact.send')); ?>

                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-unified-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-unified-motion-style';
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

            .vg-reveal-up {
                opacity: 0;
                transform: translateY(42px);
                transition: opacity 1.15s ease, transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
                will-change: opacity, transform;
            }

            .vg-visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
        `;
        document.head.appendChild(style);
    }

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

    const header = document.querySelector('header');
    const panel = document.querySelector('.theme-panel');
    const alerts = Array.from(document.querySelectorAll('.theme-panel > div.mb-6'));
    const form = document.querySelector('form');
    const submitButton = form ? form.querySelector('button[type="submit"]') : null;
    const inputs = Array.from(document.querySelectorAll('input, select, textarea'));

    if (!prefersReducedMotion) {
        if (header) {
            header.classList.add('vg-reveal-up');
            setTimeout(() => header.classList.add('vg-visible'), 120);
        }

        if (panel) {
            panel.style.opacity = '0';
            panel.style.transform = 'translateY(36px)';
            panel.style.transition = 'opacity 1.1s ease, transform 1.1s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                panel.style.opacity = '1';
                panel.style.transform = 'translateY(0)';
            }, 420);
        }

        alerts.forEach((alert, index) => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(18px)';
            alert.style.transition = 'opacity 0.9s ease, transform 0.9s ease';
            setTimeout(() => {
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
            }, 700 + (index * 140));
        });

        inputs.forEach((field, index) => {
            field.style.opacity = '0';
            field.style.transform = 'translateY(24px)';
            field.style.transition = 'opacity 0.9s ease, transform 0.9s cubic-bezier(0.22, 1, 0.36, 1)';
            setTimeout(() => {
                field.style.opacity = '1';
                field.style.transform = 'translateY(0)';
            }, 780 + (index * 90));
        });

        if (submitButton) {
            submitButton.style.opacity = '0';
            submitButton.style.transform = 'translateY(20px)';
            submitButton.style.transition = 'opacity 0.95s ease, transform 0.95s ease';
            setTimeout(() => {
                submitButton.style.opacity = '1';
                submitButton.style.transform = 'translateY(0)';
            }, 1380);
        }
    }

    if (panel) {
        panel.style.transition = 'transform 0.32s ease, box-shadow 0.32s ease';

        panel.addEventListener('mouseenter', function () {
            if (prefersReducedMotion) return;
            panel.style.transform = 'translateY(-6px)';
            panel.style.boxShadow = '0 22px 48px rgba(0,0,0,0.09)';
        });

        panel.addEventListener('mouseleave', function () {
            panel.style.transform = 'translateY(0)';
            panel.style.boxShadow = '';
        });
    }

    inputs.forEach(field => {
        field.style.transition = 'border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease';

        field.addEventListener('focus', function () {
            field.style.outline = 'none';
            field.style.boxShadow = '0 0 0 3px rgba(99,102,241,0.14)';
            field.style.transform = 'translateY(-1px)';
        });

        field.addEventListener('blur', function () {
            field.style.boxShadow = '';
            field.style.transform = '';
        });
    });

    const messageField = document.getElementById('message');
    if (messageField) {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-theme-muted mt-2 text-right';
        messageField.insertAdjacentElement('afterend', counter);

        function updateCounter() {
            const length = messageField.value.length;
            counter.textContent = `${length} / 5000`;

            if (length > 4500) {
                counter.className = 'text-xs mt-2 text-right text-red-500';
            } else if (length > 3500) {
                counter.className = 'text-xs mt-2 text-right text-yellow-500';
            } else {
                counter.className = 'text-xs text-theme-muted mt-2 text-right';
            }
        }

        updateCounter();
        messageField.addEventListener('input', updateCounter);
    }

    const subjectField = document.getElementById('subject');
    if (subjectField) {
        subjectField.addEventListener('change', function () {
            subjectField.style.borderColor = 'rgba(99,102,241,0.65)';
            setTimeout(() => {
                subjectField.style.borderColor = '';
            }, 700);
        });
    }

    if (form && submitButton) {
        const originalHTML = submitButton.innerHTML;

        form.addEventListener('submit', function () {
            submitButton.disabled = true;
            submitButton.style.pointerEvents = 'none';
            submitButton.style.opacity = '0.92';
            submitButton.innerHTML = `
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
                    Sending...
                </span>
            `;
        });

        window.addEventListener('pageshow', function () {
            submitButton.disabled = false;
            submitButton.style.pointerEvents = '';
            submitButton.style.opacity = '';
            submitButton.innerHTML = originalHTML;
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/frontend/utility/contact.blade.php ENDPATH**/ ?>