<?php $__env->startSection('title', __('backend.auth_role_policies_index.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        <div class="card-box mb-30" style="border-radius: 18px; overflow: hidden;">
            <div class="pd-20 d-flex justify-content-between align-items-center flex-wrap"
                 style="background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%); color: white;">
                <div>
                    <h4 class="mb-1 text-white"><?php echo e(__('backend.auth_role_policies_index.page_title')); ?></h4>
                    <p class="mb-0" style="opacity: .9;">
                        <?php echo e(__('backend.auth_role_policies_index.page_subtitle')); ?>

                    </p>
                </div>
            </div>

            <div class="pb-20">
                <div class="table-responsive">
                    <table class="table table-striped hover nowrap mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th>#</th>
                                <th><?php echo e(__('backend.auth_role_policies_index.role')); ?></th>
                                <th><?php echo e(__('backend.auth_role_policies_index.email_verification')); ?></th>
                                <th><?php echo e(__('backend.auth_role_policies_index.otp')); ?></th>
                                <th><?php echo e(__('backend.auth_role_policies_index.trusted_devices')); ?></th>
                                <th><?php echo e(__('backend.auth_role_policies_index.recovery_codes')); ?></th>
                                <th><?php echo e(__('backend.auth_role_policies_index.remember_me')); ?></th>
                                <th width="170"><?php echo e(__('backend.auth_role_policies_index.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rolePolicies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rolePolicy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>

                                    <td>
                                        <span class="badge badge-primary" style="padding: 8px 12px; border-radius: 999px;">
                                            <?php echo e($rolePolicy->role_name); ?>

                                        </span>
                                    </td>

                                    <td><?php echo e(ucfirst($rolePolicy->email_verification_mode)); ?></td>
                                    <td><?php echo e(ucfirst($rolePolicy->otp_mode)); ?></td>
                                    <td><?php echo e($rolePolicy->trusted_devices_enabled ? __('backend.auth_role_policies_index.enabled') : __('backend.auth_role_policies_index.disabled')); ?></td>
                                    <td><?php echo e($rolePolicy->recovery_codes_enabled ? __('backend.auth_role_policies_index.enabled') : __('backend.auth_role_policies_index.disabled')); ?></td>
                                    <td><?php echo e($rolePolicy->remember_me_enabled ? __('backend.auth_role_policies_index.enabled') : __('backend.auth_role_policies_index.disabled')); ?></td>

                                    <td>
                                        <a href="<?php echo e(route('admin.auth-role-policies.show', $rolePolicy->id)); ?>"
                                           class="btn btn-primary btn-sm"
                                           style="border-radius: 10px; font-weight: 600;">
                                            <?php echo e(__('backend.auth_role_policies_index.manage_role_policy')); ?>

                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4"><?php echo e(__('backend.auth_role_policies_index.no_role_policies_found')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/admin/auth-role-policies/index.blade.php ENDPATH**/ ?>