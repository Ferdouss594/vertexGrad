<?php $__env->startSection('title', __('backend.final_decisions_index.page_title')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalProjects = $projects->total();
    $publishedCount = $projects->getCollection()->where('final_decision', 'published')->count();
    $revisionCount = $projects->getCollection()->where('final_decision', 'revision_requested')->count();
    $rejectedCount = $projects->getCollection()->where('final_decision', 'rejected')->count();
?>

<style>
    .final-decisions-page .page-header-card {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
        border-radius: 22px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16);
        margin-bottom: 24px;
        border: none;
    }

    .final-decisions-page .page-header-title {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .final-decisions-page .page-header-text {
        font-size: 14px;
        color: rgba(255,255,255,.88);
        margin-bottom: 0;
        max-width: 760px;
    }

    .final-decisions-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        height: 100%;
    }

    .final-decisions-page .stats-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .final-decisions-page .stats-value {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .final-decisions-page .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .final-decisions-page .table-card .card-header {
        background: #fff;
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
    }

    .final-decisions-page .table-card .card-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .final-decisions-page .table {
        margin-bottom: 0;
    }

    .final-decisions-page .table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .final-decisions-page .table tbody td {
        vertical-align: middle;
        border-color: #eef2f7;
    }

    .final-decisions-page .project-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .final-decisions-page .project-sub {
        font-size: 12px;
        color: #64748b;
    }

    .final-decisions-page .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .final-decisions-page .badge-published {
        background: #dcfce7;
        color: #166534;
    }

    .final-decisions-page .badge-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .final-decisions-page .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .final-decisions-page .badge-pending {
        background: #e2e8f0;
        color: #334155;
    }

    .final-decisions-page .review-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 12px;
        margin-right: 6px;
    }

    .final-decisions-page .review-approved {
        background: #dcfce7;
        color: #166534;
    }

    .final-decisions-page .review-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .final-decisions-page .review-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .final-decisions-page .review-score {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .final-decisions-page .action-btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 9px 14px;
    }

    .final-decisions-page .empty-state {
        padding: 42px 20px;
        text-align: center;
        color: #64748b;
    }

    .final-decisions-page .pagination {
        justify-content: center;
        margin-top: 22px;
    }

    .final-decisions-page .pagination .page-link {
        border-radius: 12px !important;
        margin: 0 4px;
        border: 1px solid #dbe4f0;
        color: #334155;
        min-width: 42px;
        text-align: center;
        font-weight: 700;
        box-shadow: none !important;
    }

    .final-decisions-page .pagination .page-item.active .page-link {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
    }
</style>

<div class="container-fluid final-decisions-page">

    <div class="page-header-card">
        <div class="page-header-title"><?php echo e(__('backend.final_decisions_index.heading')); ?></div>
        <p class="page-header-text">
            <?php echo e(__('backend.final_decisions_index.subtitle')); ?>

        </p>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label"><?php echo e(__('backend.final_decisions_index.projects_with_reviews')); ?></div>
                <div class="stats-value"><?php echo e($totalProjects); ?></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label"><?php echo e(__('backend.final_decisions_index.published')); ?></div>
                <div class="stats-value"><?php echo e($publishedCount); ?></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label"><?php echo e(__('backend.final_decisions_index.revision_requested')); ?></div>
                <div class="stats-value"><?php echo e($revisionCount); ?></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label"><?php echo e(__('backend.final_decisions_index.rejected')); ?></div>
                <div class="stats-value"><?php echo e($rejectedCount); ?></div>
            </div>
        </div>
    </div>

    <div class="card table-card">
        <div class="card-header">
            <h5><?php echo e(__('backend.final_decisions_index.projects_pending_final_review')); ?></h5>
        </div>

        <div class="card-body p-0">
            <?php if($projects->count()): ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th><?php echo e(__('backend.final_decisions_index.project')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.student')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.category')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.reviews')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.average_score')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.final_decision')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.manager')); ?></th>
                                <th><?php echo e(__('backend.final_decisions_index.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $avgScore = round($project->reviews->whereNotNull('score')->avg('score') ?? 0, 1);
                                    $approved = $project->reviews->where('decision', 'approved')->count();
                                    $revision = $project->reviews->where('decision', 'revision_requested')->count();
                                    $rejected = $project->reviews->where('decision', 'rejected')->count();

                                    $finalDecisionClass = match($project->final_decision) {
                                        'published' => 'badge-published',
                                        'revision_requested' => 'badge-revision',
                                        'rejected' => 'badge-rejected',
                                        default => 'badge-pending',
                                    };

                                    $finalDecisionText = match($project->final_decision) {
                                        'published' => __('backend.final_decisions_index.final_decision_published'),
                                        'revision_requested' => __('backend.final_decisions_index.final_decision_revision_requested'),
                                        'rejected' => __('backend.final_decisions_index.final_decision_rejected'),
                                        default => __('backend.final_decisions_index.final_decision_pending'),
                                    };
                                ?>

                                <tr>
                                    <td>
                                        <div class="project-title"><?php echo e($project->name); ?></div>
                                        <div class="project-sub">#<?php echo e($project->project_id); ?> • <?php echo e(ucfirst(str_replace('_', ' ', $project->status ?? 'draft'))); ?></div>
                                    </td>

                                    <td>
                                        <div class="project-title" style="font-size:14px;"><?php echo e($project->student?->name ?? '-'); ?></div>
                                        <div class="project-sub"><?php echo e($project->student?->email ?? ''); ?></div>
                                    </td>

                                    <td><?php echo e($project->category ?? '-'); ?></td>

                                    <td>
                                        <span class="review-chip review-approved" title="<?php echo e(__('backend.final_decisions_index.approved')); ?>"><?php echo e($approved); ?></span>
                                        <span class="review-chip review-revision" title="<?php echo e(__('backend.final_decisions_index.revision_requested')); ?>"><?php echo e($revision); ?></span>
                                        <span class="review-chip review-rejected" title="<?php echo e(__('backend.final_decisions_index.rejected')); ?>"><?php echo e($rejected); ?></span>
                                    </td>

                                    <td>
                                        <span class="review-score"><?php echo e($avgScore); ?></span>
                                    </td>

                                    <td>
                                        <span class="badge-soft <?php echo e($finalDecisionClass); ?>">
                                            <?php echo e($finalDecisionText); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <?php if($project->finalDecisionMaker): ?>
                                            <div class="project-title" style="font-size:14px;">
                                                <?php echo e($project->finalDecisionMaker->name); ?>

                                            </div>
                                            <div class="project-sub">
                                                <?php echo e($project->final_decided_at ? $project->final_decided_at->format('d/m/Y h:i A') : ''); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo e(route('admin.projects.final-decisions.show', $project->project_id)); ?>"
                                           class="btn btn-primary btn-sm action-btn">
                                            <?php echo e(__('backend.final_decisions_index.review_decision')); ?>

                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h6 class="fw-bold mb-2"><?php echo e(__('backend.final_decisions_index.no_reviewed_projects_found')); ?></h6>
                    <p class="mb-0"><?php echo e(__('backend.final_decisions_index.no_reviewed_projects_text')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($projects->hasPages()): ?>
        <div class="mt-3">
            <?php echo e($projects->links()); ?>

        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/admin/projects/final-decisions/index.blade.php ENDPATH**/ ?>