<?php $__env->startSection('title', __('backend.auth_login.page_title')); ?>
<?php $__env->startSection('body_class', 'login-page'); ?>

<?php $__env->startSection('auth_actions'); ?>
    <a href="<?php echo e(route('admin.register.show')); ?>" class="auth-link-btn">
        <?php echo e(__('backend.auth_login.register')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('auth_styles'); ?>
<style>
    .text-danger {
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .login-box {
        margin-top: 40px;
    }

    .select-role {
        margin-bottom: 15px;
    }

    .btn-group-toggle .btn {
        border: 1px solid #ddd;
        padding: 10px 20px;
        margin-inline-end: 5px;
        border-radius: 6px;
    }

    .btn.active {
        background-color: #1b00ff;
        color: #fff;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="<?php echo e(asset('vendors/images/login-page-img.png')); ?>" alt="<?php echo e(__('backend.auth_login.login_image_alt')); ?>">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10 p-4">

                    <div id="login-form">
                        <div class="login-title">
                            <h2 class="text-center text-primary"><?php echo e(__('backend.auth_login.heading')); ?></h2>
                        </div>

                        <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="select-role text-center mb-3">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn <?php echo e(old('role') == 'Manager' ? 'active' : ''); ?>">
                                        <input type="radio" name="role" value="Manager" <?php echo e(old('role') == 'Manager' ? 'checked' : ''); ?>>
                                        <div class="icon">
                                            <img src="<?php echo e(asset('vendors/images/briefcase.svg')); ?>" class="svg" alt="">
                                        </div>
                                        <span><?php echo e(__('backend.auth_login.i_am')); ?></span> <?php echo e(__('backend.auth_login.manager')); ?>

                                    </label>

                                    <label class="btn <?php echo e(old('role') == 'Supervisor' ? 'active' : ''); ?>">
                                        <input type="radio" name="role" value="Supervisor" <?php echo e(old('role') == 'Supervisor' ? 'checked' : ''); ?>>
                                        <div class="icon">
                                            <img src="<?php echo e(asset('vendors/images/person.svg')); ?>" class="svg" alt="">
                                        </div>
                                        <span><?php echo e(__('backend.auth_login.i_am')); ?></span> <?php echo e(__('backend.auth_login.supervisor')); ?>

                                    </label>

                                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="input-group custom mt-3">
                                <input type="text" name="login_id" class="form-control form-control-lg" placeholder="<?php echo e(__('backend.auth_login.email_or_username')); ?>" value="<?php echo e(old('login_id')); ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <?php $__errorArgs = ['login_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="input-group custom mt-3">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="<?php echo e(__('backend.auth_login.password_placeholder')); ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="row pb-30 mt-3">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1"><?php echo e(__('backend.auth_login.remember')); ?></label>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="#" id="forgot-password-toggle"><?php echo e(__('backend.auth_login.forgot_password')); ?></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo e(__('backend.auth_login.sign_in')); ?></button>
                                    <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373"><?php echo e(__('backend.auth_login.or')); ?></div>
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="<?php echo e(route('admin.register.show')); ?>">
                                        <?php echo e(__('backend.auth_login.register_to_create_account')); ?>

                                    </a>
                                </div>
                            </div>

                            <?php if(session('error')): ?>
                                <div class="text-danger mt-2 text-center"><?php echo e(session('error')); ?></div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div id="forgot-password-form" style="display:none;">
                        <div class="login-title">
                            <h2 class="text-center text-primary"><?php echo e(__('backend.auth_login.reset_password')); ?></h2>
                            <p class="text-center"><?php echo e(__('backend.auth_login.reset_password_subtitle')); ?></p>
                        </div>

                        <?php if(session('status')): ?>
                            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('password.email')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="input-group custom mt-3">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="<?php echo e(__('backend.auth_login.your_email')); ?>" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo e(__('backend.auth_login.send_reset_link')); ?></button>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a href="#" id="back-to-login"><?php echo e(__('backend.auth_login.back_to_login')); ?></a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('auth_scripts'); ?>
<script>
    document.getElementById('forgot-password-toggle').addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('forgot-password-form').style.display = 'block';
    });

    document.getElementById('back-to-login').addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('forgot-password-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/auth/login.blade.php ENDPATH**/ ?>