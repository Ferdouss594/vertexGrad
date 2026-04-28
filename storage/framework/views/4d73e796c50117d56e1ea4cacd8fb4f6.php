<?php $__env->startSection('title', __('backend.investors_edit.page_title')); ?>

<?php $__env->startSection('content'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --page-bg: #f5f7fb;
        --card-bg: #ffffff;
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --primary-soft: rgba(78, 115, 223, 0.10);
        --info-color: #36b9cc;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
        --shadow-md: 0 14px 36px rgba(18, 38, 63, 0.10);
        --radius-xl: 24px;
        --radius-lg: 20px;
        --radius-md: 16px;
        --radius-sm: 12px;
    }

    body {
        background: var(--page-bg);
    }

    .investor-edit-page {
        padding: 10px 0 24px;
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 26px 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0;
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 0.96rem;
    }

    .custom-alert {
        border: none;
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
    }

    .reset-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
        background: #eef2f8;
        color: #344054;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .reset-btn:hover {
        color: #344054;
        text-decoration: none;
    }

    .search-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .main-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .panel-head {
        padding: 22px 24px 10px;
        border-bottom: 1px solid rgba(232, 236, 244, 0.7);
    }

    .panel-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .panel-subtitle {
        margin-top: 6px;
        color: var(--text-soft);
        font-size: 0.9rem;
    }

    .table-wrap {
        padding: 20px 24px 26px;
    }

    .form-label-custom {
        font-size: 0.82rem;
        color: var(--text-soft);
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
    }

    .form-control.custom-input,
    .form-select.custom-input {
        min-height: 46px;
        border-radius: 14px;
        border: 1px solid #dfe5ef;
        box-shadow: none;
        padding: 12px 14px;
    }

    .form-control.custom-input:focus,
    .form-select.custom-input:focus {
        border-color: rgba(78, 115, 223, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.12);
    }

    textarea.custom-input {
        min-height: 120px;
        resize: vertical;
    }

    .action-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 991px) {
        .page-header-card {
            padding: 22px 20px;
        }

        .panel-head,
        .table-wrap {
            padding-left: 18px;
            padding-right: 18px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container-fluid investor-edit-page">

    <?php if(session('error')): ?>
        <div class="alert alert-danger custom-alert mb-4">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger custom-alert mb-4">
            <strong><?php echo e(__('backend.investors_edit.fix_errors')); ?></strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title"><?php echo e(__('backend.investors_edit.heading')); ?></h1>
                <p class="page-subtitle">
                    <?php echo e(__('backend.investors_edit.subtitle')); ?>

                </p>
            </div>

            <div>
                <a href="<?php echo e(route('admin.investors.show', $investor->user_id)); ?>" class="reset-btn px-4">
                    <i class="fa fa-arrow-left mr-1"></i> <?php echo e(__('backend.investors_edit.back')); ?>

                </a>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.investors.update', $investor->user_id)); ?>"
          method="POST"
          class="ajax-ui-form"
          data-submit-text="<?php echo e(__('backend.investors_edit.update_investor')); ?>"
          data-loading-text="<?php echo e(__('backend.investors_edit.updating')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">
                    <i class="fa fa-user mr-2"></i> <?php echo e(__('backend.investors_edit.account_information')); ?>

                </h2>
                <div class="panel-subtitle"><?php echo e(__('backend.investors_edit.account_information_subtitle')); ?></div>
            </div>

            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.username')); ?></label>
                        <input type="text" name="username" class="form-control custom-input"
                               value="<?php echo e(old('username', $investor->user->username ?? '')); ?>">
                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.full_name')); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control custom-input"
                               value="<?php echo e(old('name', $investor->user->name ?? '')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.email')); ?> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control custom-input"
                               value="<?php echo e(old('email', $investor->user->email ?? '')); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.status')); ?></label>
                        <select name="status" class="form-select custom-input">
                            <option value="Active" <?php echo e(old('status', $investor->user->status ?? 'Active') == 'Active' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.status_active')); ?></option>
                            <option value="Inactive" <?php echo e(old('status', $investor->user->status ?? '') == 'Inactive' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.status_inactive')); ?></option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.gender')); ?></label>
                        <select name="gender" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.investors_edit.select_gender')); ?></option>
                            <option value="male" <?php echo e(old('gender', $investor->user->gender ?? '') == 'male' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.gender_male')); ?></option>
                            <option value="female" <?php echo e(old('gender', $investor->user->gender ?? '') == 'female' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.gender_female')); ?></option>
                        </select>
                        <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.city')); ?></label>
                        <input type="text" name="city" class="form-control custom-input"
                               value="<?php echo e(old('city', $investor->user->city ?? '')); ?>">
                        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.state')); ?></label>
                        <input type="text" name="state" class="form-control custom-input"
                               value="<?php echo e(old('state', $investor->user->state ?? '')); ?>">
                        <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">
                    <i class="fa fa-briefcase mr-2"></i> <?php echo e(__('backend.investors_edit.investor_profile')); ?>

                </h2>
                <div class="panel-subtitle"><?php echo e(__('backend.investors_edit.investor_profile_subtitle')); ?></div>
            </div>

            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.phone')); ?></label>
                        <input type="text" name="phone" class="form-control custom-input"
                               value="<?php echo e(old('phone', $investor->phone ?? '')); ?>">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.company')); ?></label>
                        <input type="text" name="company" class="form-control custom-input"
                               value="<?php echo e(old('company', $investor->company ?? '')); ?>">
                        <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.position')); ?></label>
                        <input type="text" name="position" class="form-control custom-input"
                               value="<?php echo e(old('position', $investor->position ?? '')); ?>">
                        <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.investment_type')); ?></label>
                        <select name="investment_type" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.investors_edit.select_option')); ?></option>
                            <option value="Angel" <?php echo e(old('investment_type', $investor->investment_type ?? '') == 'Angel' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.investment_type_angel')); ?></option>
                            <option value="Venture Capital" <?php echo e(old('investment_type', $investor->investment_type ?? '') == 'Venture Capital' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.investment_type_venture_capital')); ?></option>
                            <option value="Private Equity" <?php echo e(old('investment_type', $investor->investment_type ?? '') == 'Private Equity' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.investment_type_private_equity')); ?></option>
                            <option value="Business Incubator" <?php echo e(old('investment_type', $investor->investment_type ?? '') == 'Business Incubator' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.investment_type_business_incubator')); ?></option>
                        </select>
                        <?php $__errorArgs = ['investment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.budget')); ?></label>
                        <input type="number" name="budget" class="form-control custom-input" step="0.01"
                               value="<?php echo e(old('budget', $investor->budget ?? '')); ?>">
                        <?php $__errorArgs = ['budget'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.source')); ?></label>
                        <select name="source" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.investors_edit.select_option')); ?></option>
                            <option value="LinkedIn" <?php echo e(old('source', $investor->source ?? '') == 'LinkedIn' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.source_linkedin')); ?></option>
                            <option value="Email" <?php echo e(old('source', $investor->source ?? '') == 'Email' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.source_email')); ?></option>
                            <option value="Event" <?php echo e(old('source', $investor->source ?? '') == 'Event' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.source_event')); ?></option>
                            <option value="Website" <?php echo e(old('source', $investor->source ?? '') == 'Website' ? 'selected' : ''); ?>><?php echo e(__('backend.investors_edit.source_website')); ?></option>
                        </select>
                        <?php $__errorArgs = ['source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label-custom"><?php echo e(__('backend.investors_edit.notes')); ?></label>
                        <textarea name="notes" class="form-control custom-input auto-resize" rows="4"><?php echo e(old('notes', $investor->investorNotes ?? '')); ?></textarea>
                        <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-bar">
            <button class="btn btn-primary search-btn" type="submit">
                <i class="fa fa-save mr-1"></i> <?php echo e(__('backend.investors_edit.update_investor')); ?>

            </button>

            <a href="<?php echo e(route('admin.investors.show', $investor->user_id)); ?>" class="reset-btn">
                <?php echo e(__('backend.investors_edit.cancel')); ?>

            </a>
        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.auto-resize').forEach(el => {
        const resize = () => {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        };

        el.addEventListener('input', resize);
        resize();
    });

    document.querySelectorAll('.ajax-ui-form').forEach(form => {
        form.addEventListener('submit', function () {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> ' + (form.dataset.loadingText || '<?php echo e(__('backend.investors_edit.processing')); ?>');
        });
    });

    document.querySelectorAll('.page-header-card, .form-animate').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';

        setTimeout(() => {
            card.style.transition = 'all 0.35s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 80 * (index + 1));
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/investors/edit.blade.php ENDPATH**/ ?>