<?php $__env->startSection('title', __('backend.students_edit.title')); ?>

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
        --success-color: #1cc88a;
        --success-soft: rgba(28, 200, 138, 0.12);
        --danger-color: #e74a3b;
        --danger-soft: rgba(231, 74, 59, 0.12);
        --warning-color: #f6c23e;
        --warning-soft: rgba(246, 194, 62, 0.14);
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
    }

    body {
        background: var(--page-bg);
    }

    .student-page {
        padding: 10px 0 24px;
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid var(--border-color);
        border-radius: 24px;
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
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    .main-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .card-head {
        padding: 22px 24px 14px;
        border-bottom: 1px solid rgba(232, 236, 244, 0.8);
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
    }

    .card-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .card-subtitle {
        margin-top: 6px;
        color: var(--text-soft);
        font-size: 0.9rem;
    }

    .card-body-custom {
        padding: 24px;
    }

    .section-block {
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 20px;
        background: #fff;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.96rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 18px;
    }

    .icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .form-label {
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid #dfe5ef;
        box-shadow: none;
        padding: 12px 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(78, 115, 223, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.12);
    }

    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 22px;
        border-top: 1px solid rgba(232, 236, 244, 0.8);
        margin-top: 24px;
    }

    .btn-soft-back {
        background: #eef2f8;
        color: #344054;
        border: none;
        border-radius: 14px;
        padding: 11px 18px;
        font-weight: 700;
    }

    .btn-update-student {
        background: linear-gradient(135deg, var(--primary-color), #6f8df3);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 12px 22px;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(78, 115, 223, 0.18);
        transition: all 0.2s ease;
    }

    .btn-update-student:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .error-list {
        margin: 0;
        padding-left: 1rem;
    }

    @media (max-width: 768px) {
        .page-header-card,
        .card-body-custom {
            padding: 20px;
        }

        .actions-bar {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .actions-bar .btn,
        .actions-bar a {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container-fluid student-page">
    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title"><?php echo e(__('backend.students_edit.page_title')); ?></h1>
                <p class="page-subtitle">
                    <?php echo e(__('backend.students_edit.page_subtitle')); ?>

                </p>
            </div>

            <div>
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-soft-back">
                    <i class="bi bi-arrow-left me-2"></i><?php echo e(__('backend.students_edit.back_to_students')); ?>

                </a>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger custom-alert mb-4" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <div>
                    <div class="fw-bold mb-1"><?php echo e(__('backend.students_edit.errors_review')); ?></div>
                    <ul class="error-list">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.students.update', $student->id)); ?>" method="POST" id="studentEditForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="main-card">
            <div class="card-head">
                <h2 class="card-title"><?php echo e(__('backend.students_edit.form_title')); ?></h2>
                <div class="card-subtitle"><?php echo e(__('backend.students_edit.form_subtitle')); ?></div>
            </div>

            <div class="card-body-custom">
                <div class="section-block mb-4">
                    <div class="section-title">
                        <span class="icon-wrap"><i class="bi bi-person-lines-fill"></i></span>
                        <?php echo e(__('backend.students_edit.basic_user_information')); ?>

                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('backend.students_edit.name')); ?></label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $student->name)); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('backend.students_edit.email')); ?></label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $student->email)); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('backend.students_edit.status')); ?></label>
                            <select name="status" class="form-select" required>
                                <option value="active" <?php echo e(old('status', $student->status) == 'active' ? 'selected' : ''); ?>><?php echo e(__('backend.students_edit.status_active')); ?></option>
                                <option value="pending" <?php echo e(old('status', $student->status) == 'pending' ? 'selected' : ''); ?>><?php echo e(__('backend.students_edit.status_pending')); ?></option>
                                <option value="inactive" <?php echo e(old('status', $student->status) == 'inactive' ? 'selected' : ''); ?>><?php echo e(__('backend.students_edit.status_inactive')); ?></option>
                                <option value="disabled" <?php echo e(old('status', $student->status) == 'disabled' ? 'selected' : ''); ?>><?php echo e(__('backend.students_edit.status_disabled')); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="section-block">
                    <div class="section-title">
                        <span class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></span>
                        <?php echo e(__('backend.students_edit.academic_information')); ?>

                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.major')); ?></label>
                            <input type="text" name="major" class="form-control" value="<?php echo e(old('major', $student->student->major ?? '')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.phone')); ?></label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $student->student->phone ?? '')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.address')); ?></label>
                            <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $student->student->address ?? '')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.current_courses')); ?></label>
                            <input type="text" name="current_courses" class="form-control" value="<?php echo e(old('current_courses', $student->student->current_courses ?? '')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.completed_courses')); ?></label>
                            <input type="text" name="completed_courses" class="form-control" value="<?php echo e(old('completed_courses', $student->student->completed_courses ?? '')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(__('backend.students_edit.academic_advisor')); ?></label>
                            <input type="text" name="academic_advisor" class="form-control" value="<?php echo e(old('academic_advisor', $student->student->academic_advisor ?? '')); ?>">
                        </div>
                    </div>
                </div>

                <div class="actions-bar">
                    <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-soft-back">
                        <i class="bi bi-arrow-left me-2"></i><?php echo e(__('backend.students_edit.back')); ?>

                    </a>

                    <button type="submit" class="btn btn-update-student" id="submitUpdateBtn">
                        <i class="bi bi-check2-circle me-2"></i><?php echo e(__('backend.students_edit.update_student')); ?>

                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('studentEditForm');
        const submitBtn = document.getElementById('submitUpdateBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span><?php echo e(__('backend.students_edit.updating')); ?>';
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/students/edit.blade.php ENDPATH**/ ?>