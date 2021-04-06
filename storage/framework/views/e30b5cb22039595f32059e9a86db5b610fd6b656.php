
<?php $__env->startSection('modal-title','Modificar Dispositivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="device-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control" id="internal_id" name="internal_id" value="<?php echo e($device->internal_id); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($device->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select class="form-control m-b" name="device_type_id" id="device_type_id">
                <option value="" disabled="" selected="" >Seleccione...</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($type->id = $device->device_type_id): ?>
                        <option value="<?php echo e($type->id); ?>" selected><?php echo e($type->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <label class="custom-control custom-checkbox">
            <input type="checkbox"  class="custom-control-input" value="1" <?php if($device->from_bio === 1): ?> checked <?php endif; ?> name="from_bio">
            <span class="custom-control-label">Datos desde bioseguridad</span>
        </label>
        <label class="custom-control custom-checkbox">
            <input type="checkbox"  class="custom-control-input" value="1" <?php if($device->from_dpl === 1): ?> checked <?php endif; ?> name="from_dpl">
            <span class="custom-control-label">Datos desde DPL</span>
        </label>

    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#device-form','/devices/'.$device->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/edit.blade.php ENDPATH**/ ?>