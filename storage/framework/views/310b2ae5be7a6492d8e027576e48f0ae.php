<?php $__env->startSection('title', __('backend.manager_users_create.page_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?php echo e(__('backend.manager_users_create.heading')); ?></h4>
        </div>
        <div class="card-body">

            <form action="<?php echo e(route('manager.users.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="text-center mb-4">
                    <div style="position: relative; display: inline-block; width: 150px; height: 150px;">
                        <img id="imagePreview" src="<?php echo e(asset('src/images/avatar.png')); ?>"
                            alt="<?php echo e(__('backend.manager_users_create.profile_preview')); ?>"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">

                        <label for="profileImage"
                            style="position: absolute; bottom: -10px; right: -10px;
                                   width: 50px; height: 50px; background-color: #5bc0de;
                                   color: white; border-radius: 50%; display: flex;
                                   justify-content: center; align-items: center;
                                   cursor: pointer; font-weight: bold; font-size: 24px;">
                            +
                        </label>
                        <input type="file" name="profile_image" id="profileImage" class="d-none" accept="image/*">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.username')); ?></label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.full_name')); ?></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.email')); ?></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.role')); ?></label>
                        <select name="role" class="form-select">
                            <option value="Student"><?php echo e(__('backend.manager_users_create.roles.student')); ?></option>
                            <option value="Supervisor"><?php echo e(__('backend.manager_users_create.roles.supervisor')); ?></option>
                            <option value="Manager"><?php echo e(__('backend.manager_users_create.roles.manager')); ?></option>
                            <option value="Investor"><?php echo e(__('backend.manager_users_create.roles.investor')); ?></option>
                            <option value="Admin"><?php echo e(__('backend.manager_users_create.roles.admin')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.status')); ?></label>
                        <select name="status" class="form-select">
                            <option value="active"><?php echo e(__('backend.manager_users_create.statuses.active')); ?></option>
                            <option value="inactive"><?php echo e(__('backend.manager_users_create.statuses.inactive')); ?></option>
                            <option value="pending" selected><?php echo e(__('backend.manager_users_create.statuses.pending')); ?></option>
                            <option value="disabled"><?php echo e(__('backend.manager_users_create.statuses.disabled')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.gender')); ?></label>
                        <select name="gender" class="form-select">
                            <option value=""><?php echo e(__('backend.manager_users_create.select')); ?></option>
                            <option value="male"><?php echo e(__('backend.manager_users_create.genders.male')); ?></option>
                            <option value="female"><?php echo e(__('backend.manager_users_create.genders.female')); ?></option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.city')); ?></label>
                        <input type="text" name="city" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.state_country')); ?></label>
                        <input type="text" name="state" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.password')); ?></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('backend.manager_users_create.confirm_password')); ?></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn px-5 py-2" style="background-color: #003366; color: white; font-weight: bold;">
                        <?php echo e(__('backend.manager_users_create.add_user')); ?>

                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const profileImage = document.getElementById('profileImage');
    const imagePreview = document.getElementById('imagePreview');

    profileImage.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "<?php echo e(asset('src/images/avatar.png')); ?>";
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/manager/create_user.blade.php ENDPATH**/ ?>