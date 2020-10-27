<?php $__env->startSection('page-title','Login'); ?>

<?php $__env->startSection('auth-content'); ?>
    <form id="login-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label" for="username">E-mail</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="email" value="">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Contraseña</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="******" value="">
        </div>
        <div class="form-group text-left">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="rememberMe" id="rememberme">
                <label class="custom-control-label" for="rememberme"> Recuérdame</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(route('main.forgot-password')); ?>" class="btn btn-link">Olvidó su contraseña?</a>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-lg-12 pr-lg-1 my-2">
                <button type="submit" class="btn btn-info btn-block btn-lg">Ingresar</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('validation'); ?>
    <?php echo makeValidation('#login-form','/login',"location.href = '/';"); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('auth.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sebaaraya/devilbox/data/www/erm/resources/views/auth/pages/login.blade.php ENDPATH**/ ?>