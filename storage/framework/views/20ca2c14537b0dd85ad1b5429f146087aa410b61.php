
<?php $__env->startSection('modal-title','Modificar cronómetro para el sensor: '.$sensor->name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="chronometer-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <input type="hidden" name="sensor_id" value="<?php echo e($sensor->id); ?>">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($chronometer->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Ejecutar cuando el valor sea igual que</label>
            <input type="text" class="form-control" id="equals_to" name="equals_to" value="<?php echo e($chronometer->equals_to); ?>">
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#chronometer-form','/sensor-chronometers/'.$chronometer->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/chronometer/edit.blade.php ENDPATH**/ ?>