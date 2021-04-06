
<?php $__env->startSection('auth-content'); ?>
    <h4 class="text-center text-lighter font-weight-normal mt-5 mb-0">Cambiar mi Contraseña</h4>

    <!-- Form -->
    <form class="my-5" id="reset-password-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label class="form-label">Re-ingrese contraseña</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <div class="d-flex justify-content-between  m-0">
            <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
        </div>
    </form>
    <!-- / Form -->

    <div class="text-center text-muted">
        <a href="<?php echo e(route('main.login')); ?>"> Volver Al Login</a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('validation'); ?>
    <?php echo makeValidation('#reset-password-form',"/reset/$user->email/$code", "location.href = '/';"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/auth/pages/reset-password.blade.php ENDPATH**/ ?>