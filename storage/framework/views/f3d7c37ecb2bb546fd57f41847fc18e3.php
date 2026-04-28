<?php $__env->startSection('content'); ?>
<?php
    $policy = $policy ?? [
        'trusted_devices_enabled' => true,
        'recovery_codes_enabled' => true,
    ];
?>

<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-72 w-72 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
        <div class="absolute bottom-0 right-0 h-64 w-64 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="theme-panel rounded-2xl shadow-brand-soft border border-theme-border/60 p-8 backdrop-blur-sm">

                <div class="text-center mb-8">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20">
                        <i class="fas fa-shield-alt text-3xl text-brand-accent"></i>
                    </div>

                    <h2 class="text-3xl font-bold text-theme-text mb-2">
                        <?php echo e(__('frontend.auth.verify_login_title')); ?>

                    </h2>

                    <p class="text-theme-muted leading-relaxed">
                        <?php echo e(__('frontend.auth.verify_login_subtitle')); ?>

                    </p>
                </div>

                <?php if(session('status')): ?>
                    <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-circle-check mt-0.5"></i>
                            <span><?php echo e(session('status')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-6 rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-500">
                        <ul class="list-disc list-inside space-y-1 text-left">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login.otp.verify')); ?>" id="otpVerifyForm" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="code" class="mb-2 block text-sm font-medium text-theme-muted">
                            <?php echo e(__('frontend.auth.verification_code')); ?>

                        </label>

                        <input
                            type="text"
                            id="code"
                            name="code"
                            inputmode="numeric"
                            maxlength="6"
                            value="<?php echo e(old('code')); ?>"
                            required
                            autocomplete="one-time-code"
                            placeholder="000000"
                            class="w-full rounded-xl border border-theme-border bg-theme-surface-2 py-3 px-4 text-center text-xl tracking-[0.45em] text-theme-text placeholder:text-theme-muted focus:border-brand-accent focus:ring-0"
                        >
                    </div>

                    <?php if(($policy['trusted_devices_enabled'] ?? true) === true): ?>
                        <div class="flex items-center justify-start">
                            <label class="inline-flex items-center gap-2 text-sm text-theme-muted cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="trust_device"
                                    value="1"
                                    class="rounded border-theme-border bg-theme-surface-2 text-brand-accent focus:ring-brand-accent"
                                >
                                <span><?php echo e(__('frontend.auth.trust_device_30_days')); ?></span>
                            </label>
                        </div>
                    <?php endif; ?>

                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-base font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <i class="fas fa-shield-check"></i>
                        <span><?php echo e(__('frontend.auth.verify_and_continue')); ?></span>
                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('login.otp.resend')); ?>" class="mt-4" id="otpResendForm">
                    <?php echo csrf_field(); ?>
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                    >
                        <i class="fas fa-rotate-right"></i>
                        <span><?php echo e(__('frontend.auth.resend_code')); ?></span>
                    </button>
                </form>

                <?php if(($policy['recovery_codes_enabled'] ?? true) === true): ?>
                    <div class="mt-6 pt-6 border-t border-theme-border/60">
                        <p class="text-sm text-theme-muted mb-3 text-center">
                            <?php echo e(__('frontend.auth.cant_access_email_code')); ?>

                        </p>

                        <button
                            type="button"
                            onclick="document.getElementById('recoveryCodeBox').classList.toggle('hidden')"
                            class="w-full text-brand-accent text-sm font-semibold hover:underline"
                        >
                            <?php echo e(__('frontend.auth.use_recovery_code_instead')); ?>

                        </button>

                        <div id="recoveryCodeBox" class="hidden mt-4">
                            <form method="POST" action="<?php echo e(route('login.otp.recovery')); ?>" class="space-y-4">
                                <?php echo csrf_field(); ?>

                                <input
                                    type="text"
                                    name="recovery_code"
                                    required
                                    placeholder="<?php echo e(__('frontend.auth.recovery_code_placeholder')); ?>"
                                    class="w-full rounded-xl border border-theme-border bg-theme-surface-2 py-3 px-4 text-theme-text focus:border-brand-accent focus:ring-0"
                                >

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                                >
                                    <i class="fas fa-key"></i>
                                    <span><?php echo e(__('frontend.auth.use_recovery_code')); ?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-8 border-t border-theme-border/60 pt-6 text-center">
                    <a href="<?php echo e(route('login.show')); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-brand-accent hover:underline">
                        <i class="fas fa-arrow-left"></i>
                        <span><?php echo e(__('frontend.auth.back_to_login')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const panel = document.querySelector('.theme-panel');
    const verifyForm = document.getElementById('otpVerifyForm');
    const resendForm = document.getElementById('otpResendForm');
    const verifyButton = verifyForm?.querySelector('button[type="submit"]');
    const resendButton = resendForm?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-login-otp-style')) {
        const style = document.createElement('style');
        style.id = 'vg-login-otp-style';
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

            .vg-auth-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .vg-auth-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .vg-auth-btn {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .vg-auth-btn:hover {
                transform: translateY(-1px);
            }

            .vg-auth-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-auth-panel,
                .vg-auth-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const revealItems = [
        document.querySelector('.theme-panel .mx-auto'),
        document.querySelector('h2'),
        document.querySelector('h2 + p'),
        document.getElementById('otpVerifyForm'),
        document.getElementById('otpResendForm'),
        document.querySelector('.border-t')
    ].filter(Boolean);

    if (panel) panel.classList.add('vg-auth-panel');

    revealItems.forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 100 + (index * 100));
    });

    if (verifyButton) {
        verifyButton.classList.add('vg-auth-btn');

        verifyForm?.addEventListener('submit', () => {
            verifyButton.classList.add('is-loading');
            verifyButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    <?php echo e(__('frontend.auth.verify_and_continue')); ?>

                </span>
            `;
        });
    }

    if (resendButton) {
        resendButton.classList.add('vg-auth-btn');

        resendForm?.addEventListener('submit', () => {
            resendButton.classList.add('is-loading');
            resendButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    <?php echo e(__('frontend.auth.resend_code')); ?>

                </span>
            `;
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/frontend/auth/login-otp.blade.php ENDPATH**/ ?>