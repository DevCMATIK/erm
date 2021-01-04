<?php $__env->startSection('modal-title','Modificar Interpretadors'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="interpreter-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div class="form-group">
            <label class="form-label">Valor a comparar</label>
            <input type="text" class="form-control" id="value" name="value" value="<?php echo e($interpreter->value); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($interpreter->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo e($interpreter->description); ?>">
        </div>


    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#interpreter-form','/interpreters/'.$interpreter->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/type/interpreter/edit.blade.php ENDPATH**/ ?>