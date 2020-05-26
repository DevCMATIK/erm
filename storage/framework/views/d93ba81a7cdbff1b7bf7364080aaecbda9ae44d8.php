
<?php $__env->startSection('modal-title','Crear Tipo de Registro'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="register-type-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="internal_id">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#register-type-form','/register-types', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/register-types/create.blade.php ENDPATH**/ ?>