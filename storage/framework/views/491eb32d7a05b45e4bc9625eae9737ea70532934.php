
<?php $__env->startSection('modal-title','Crear cronómetro para el sensor: '.$sensor->name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="chronometer-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="sensor_id" value="<?php echo e($sensor->id); ?>">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="form-group">
            <label class="form-label">Ejecutar cuando el valor sea igual que</label>
            <input type="text" class="form-control" id="equals_to" name="equals_to">
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#chronometer-form','/sensor-chronometers', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/chronometer/create.blade.php ENDPATH**/ ?>