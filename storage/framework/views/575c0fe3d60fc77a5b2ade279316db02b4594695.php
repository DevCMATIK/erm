
<?php $__env->startSection('modal-title','Modificar tipo de dispositivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="device-type-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($type->name); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" id="model" name="model" value="<?php echo e($type->model); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Marca</label>
            <input type="text" class="form-control" id="brand" name="brand" value="<?php echo e($type->brand); ?>">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#device-type-form','/device-types/'.$type->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/type/edit.blade.php ENDPATH**/ ?>