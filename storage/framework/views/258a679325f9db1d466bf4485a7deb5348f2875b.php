<?php $__env->startSection('page-title','Forgot Password'); ?>
<?php $__env->startSection('auth-content'); ?>
    <h4 class="text-center text-lighter font-weight-normal mt-5 mb-0">Recuperar Contraseña</h4>

    <!-- Form -->
    <form class="my-5" id="forgot-password-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Correo electrónico</label>
            <input type="text" class="form-control" name="email">
        </div>

        <div class="d-flex justify-content-between  m-0">
            <button type="submit" class="btn btn-primary btn-block">Envíame e-mail de recuperación</button>
        </div>
    </form>
    <!-- / Form -->

    <div class="text-center text-muted">
        Recordaste tu contraseña?,
        <a href="<?php echo e(route('main.login')); ?>"> Volver Al Login</a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('validation'); ?>
    <?php echo makeValidation('#forgot-password-form','/forgot-password', "location.href = '/';"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/auth/pages/forgot-password.blade.php ENDPATH**/ ?>