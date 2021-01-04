
<?php $__env->startSection('modal-title','Crear Tipo de dispositivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="device-type-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" id="model" name="model">
        </div>
        <div class="form-group">
            <label class="form-label">Marca</label>
            <input type="text" class="form-control" id="brand" name="brand">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#device-type-form','/device-types', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/type/create.blade.php ENDPATH**/ ?>