<?php $__env->startSection('modal-title','Crear Dispositivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="device-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="check_point_id" value="<?php echo e($check_point_id); ?>">
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control" id="internal_id" name="internal_id">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select class="form-control m-b" name="device_type_id" id="device_type_id">
                <option value="" disabled="" selected="" >Seleccione...</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <br>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" checked="checked" class="custom-control-input" value="1" name="from_bio">
            <span class="custom-control-label">Dato desde bioseguridad</span>
        </label>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#device-form','/devices', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/create.blade.php ENDPATH**/ ?>