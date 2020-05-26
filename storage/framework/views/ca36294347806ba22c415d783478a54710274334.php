<?php $__env->startSection('modal-title','Crear Interpretador'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="interpreter-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="type_id" value="<?php echo e($type_id); ?>">

        <div class="form-group">
            <label class="form-label">Valor a comparar</label>
            <input type="text" class="form-control" id="value" name="value">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#interpreter-form','/interpreters', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/type/interpreter/create.blade.php ENDPATH**/ ?>