<?php $__env->startSection('title', __('backend.projects_create.page_title')); ?>

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

    .create-project-page {
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

    .helper-text {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
    }

    .section-note {
        background: #f8fbff;
        border: 1px solid #dbeafe;
        color: #335c85;
        padding: 14px 16px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
    }

    .preview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px;
    }

    .preview-card img,
    .preview-card video {
        display: block;
        max-width: 180px;
        border-radius: 10px;
        border: 1px solid #dbe4f0;
    }

    .preview-card video {
        max-width: 320px;
    }

    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
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

<div class="container-fluid create-project-page">

    <?php if($errors->any()): ?>
        <div class="alert alert-danger custom-alert mb-4">
            <strong><?php echo e(__('backend.projects_create.please_fix_errors')); ?></strong>
            <ul class="mb-0 mt-2 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title"><?php echo e(__('backend.projects_create.heading')); ?></h1>
                <p class="page-subtitle">
                    <?php echo e(__('backend.projects_create.subtitle')); ?>

                </p>
            </div>

            <div>
                <a href="<?php echo e(route('admin.projects.index')); ?>" class="reset-btn px-4">
                    <i class="fa fa-arrow-left mr-1"></i> <?php echo e(__('backend.projects_create.back_to_projects')); ?>

                </a>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.projects.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title"><?php echo e(__('backend.projects_create.project_information')); ?></h2>
                <div class="panel-subtitle"><?php echo e(__('backend.projects_create.project_information_subtitle')); ?></div>
            </div>
            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.project_name_required')); ?></label>
                        <input type="text" name="name" class="form-control custom-input" value="<?php echo e(old('name')); ?>" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.category')); ?></label>
                        <select name="category" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.projects_create.select_category')); ?></option>
                            <option value="ai_ml" <?php echo e(old('category')=='ai_ml' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.ai_ml')); ?></option>
                            <option value="biotech" <?php echo e(old('category')=='biotech' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.biotech')); ?></option>
                            <option value="materials" <?php echo e(old('category')=='materials' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.materials')); ?></option>
                            <option value="energy" <?php echo e(old('category')=='energy' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.energy')); ?></option>
                            <option value="quantum" <?php echo e(old('category')=='quantum' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.quantum')); ?></option>
                            <option value="aero" <?php echo e(old('category')=='aero' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.aero')); ?></option>
                            <option value="other" <?php echo e(old('category')=='other' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.categories.other')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-0">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.description')); ?></label>
                        <textarea name="description" class="form-control custom-input" rows="5"><?php echo e(old('description')); ?></textarea>
                        <div class="helper-text">
                            <?php echo e(__('backend.projects_create.description_helper')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title"><?php echo e(__('backend.projects_create.assign_users')); ?></h2>
                <div class="panel-subtitle"><?php echo e(__('backend.projects_create.assign_users_subtitle')); ?></div>
            </div>
            <div class="table-wrap">
                <div class="section-note">
                    <?php echo e(__('backend.projects_create.assign_users_note')); ?>

                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.student_required')); ?></label>
                        <select name="student_id" class="form-select custom-input" required>
                            <option value=""><?php echo e(__('backend.projects_create.select_student')); ?></option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" <?php echo e(old('student_id') == $student->id ? 'selected' : ''); ?>>
                                    <?php echo e($student->name); ?> (<?php echo e($student->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.supervisor')); ?></label>
                        <select name="supervisor_id" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.projects_create.select_supervisor')); ?></option>
                            <?php $__currentLoopData = $supervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supervisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($supervisor->id); ?>" <?php echo e(old('supervisor_id') == $supervisor->id ? 'selected' : ''); ?>>
                                    <?php echo e($supervisor->name); ?> (<?php echo e($supervisor->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.manager')); ?></label>
                        <select name="manager_id" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.projects_create.select_manager')); ?></option>
                            <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($manager->id); ?>" <?php echo e(old('manager_id') == $manager->id ? 'selected' : ''); ?>>
                                    <?php echo e($manager->name); ?> (<?php echo e($manager->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-0">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.investor')); ?></label>
                        <select name="investor_id" class="form-select custom-input">
                            <option value=""><?php echo e(__('backend.projects_create.select_investor')); ?></option>
                            <?php $__currentLoopData = $investors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($investor->id); ?>" <?php echo e(old('investor_id') == $investor->id ? 'selected' : ''); ?>>
                                    <?php echo e($investor->name); ?> (<?php echo e($investor->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title"><?php echo e(__('backend.projects_create.status_meta_information')); ?></h2>
                <div class="panel-subtitle"><?php echo e(__('backend.projects_create.status_meta_information_subtitle')); ?></div>
            </div>
            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.status_required')); ?></label>
                        <select name="status" class="form-select custom-input" required>
                            <option value="pending" <?php echo e(old('status')=='pending' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_pending')); ?></option>
                            <option value="scan_requested" <?php echo e(old('status')=='scan_requested' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_scan_requested')); ?></option>
                            <option value="awaiting_manual_review" <?php echo e(old('status')=='awaiting_manual_review' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_awaiting_manual_review')); ?></option>
                            <option value="approved" <?php echo e(old('status')=='approved' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_approved')); ?></option>
                            <option value="published" <?php echo e(old('status')=='published' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_published')); ?></option>
                            <option value="active" <?php echo e(old('status')=='active' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_active')); ?></option>
                            <option value="completed" <?php echo e(old('status')=='completed' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_completed')); ?></option>
                            <option value="rejected" <?php echo e(old('status')=='rejected' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_rejected')); ?></option>
                            <option value="scan_failed" <?php echo e(old('status')=='scan_failed' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.status_scan_failed')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.budget')); ?></label>
                        <input type="number" step="0.01" min="0" name="budget" class="form-control custom-input" value="<?php echo e(old('budget')); ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.priority')); ?></label>
                        <select name="priority" class="form-select custom-input">
                            <option value="Low" <?php echo e(old('priority')=='Low' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.priority_low')); ?></option>
                            <option value="Medium" <?php echo e(old('priority', 'Medium')=='Medium' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.priority_medium')); ?></option>
                            <option value="High" <?php echo e(old('priority')=='High' ? 'selected' : ''); ?>><?php echo e(__('backend.projects_create.priority_high')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.start_date')); ?></label>
                        <input type="date" name="start_date" class="form-control custom-input" value="<?php echo e(old('start_date')); ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.end_date')); ?></label>
                        <input type="date" name="end_date" class="form-control custom-input" value="<?php echo e(old('end_date')); ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom"><?php echo e(__('backend.projects_create.progress_percent')); ?></label>
                        <input type="number" name="progress" class="form-control custom-input" value="<?php echo e(old('progress', 0)); ?>" min="0" max="100">
                    </div>

                    <div class="col-md-12 mb-0">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                            <label class="form-check-label font-weight-bold" for="is_featured">
                                <?php echo e(__('backend.projects_create.featured_project')); ?>

                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title"><?php echo e(__('backend.projects_create.media_upload')); ?></h2>
                <div class="panel-subtitle"><?php echo e(__('backend.projects_create.media_upload_subtitle')); ?></div>
            </div>
            <div class="table-wrap">
                <div class="section-note">
                    <?php echo e(__('backend.projects_create.media_upload_note')); ?>

                </div>

                <div class="mb-4">
                    <label class="form-label-custom"><?php echo e(__('backend.projects_create.project_photos_multiple')); ?></label>
                    <input type="file"
                           name="project_photos[]"
                           multiple
                           accept="image/*"
                           class="form-control custom-input"
                           onchange="previewSpecific(this, 'images_preview')">
                    <div id="images_preview" class="preview-grid"></div>
                </div>

                <div class="mb-0">
                    <label class="form-label-custom"><?php echo e(__('backend.projects_create.project_video_single')); ?></label>
                    <input type="file"
                           name="project_video"
                           accept="video/*"
                           class="form-control custom-input"
                           onchange="previewSpecific(this, 'videos_preview')">
                    <div id="videos_preview" class="preview-grid"></div>
                </div>
            </div>
        </div>

        <div class="action-bar">
            <button type="submit" class="btn btn-primary search-btn">
                <i class="fa fa-check-circle mr-1"></i> <?php echo e(__('backend.projects_create.create_project')); ?>

            </button>

            <a href="<?php echo e(route('admin.projects.index')); ?>" class="reset-btn">
                <?php echo e(__('backend.projects_create.cancel')); ?>

            </a>
        </div>
    </form>
</div>

<script>
function previewSpecific(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    const files = input.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-card';

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            wrapper.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            wrapper.appendChild(video);
        } else {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.textContent = '<?php echo e(__('backend.projects_create.file_label')); ?>: ' + file.name;
            link.target = '_blank';
            wrapper.appendChild(link);
        }

        preview.appendChild(wrapper);
    }
}

document.addEventListener('DOMContentLoaded', function () {
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/projects/create.blade.php ENDPATH**/ ?>