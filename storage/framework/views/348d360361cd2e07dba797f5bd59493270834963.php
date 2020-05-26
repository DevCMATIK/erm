
<?php $__env->startSection('modal-title','Resetear contraseña de usuario: ' . $user->full_name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="userPassword-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control"  name="email" readonly value="<?php echo e($user->email); ?>" >
                </div>
            </div>
        </div>
    </form>
    <p class="note"><strong>Nota: </strong>Solo use este módulo en caso de que el usuario no reciba el correo de reseteo de contraseña.</p>
    <p class="note"><strong>Nota: </strong>La Contraseña será cambiada y mostrada en este mismo pop-up. no lo cierre hasta que copie la contraseña</p>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#userPassword-form','/userPasswordReset', ""); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','40'); ?>
<?php $__env->startSection('no-submit'); ?>
    <button type="button" class="btn btn-danger" onClick="$('.modal-content form').submit();">Cambiar Contraseña</button>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/user/password/index.blade.php ENDPATH**/ ?>