
<?php $__env->startSection('modal-title','Modificar Sensor'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="sensor-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($sensor->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo Registro</label>
            <select name="address_id" class="form-control">
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($sensor->address_id == $address->id): ?>
                        <option value="<?php echo e($address->id); ?>" selected><?php echo e($address->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($address->id); ?>"><?php echo e($address->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Direccion</label>
            <input type="text" class="form-control"  name="address_number" value="<?php echo e($sensor->address_number); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Sensor</label>
            <select name="type_id" class="form-control">
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($sensor->type_id == $type->id): ?>
                        <option value="<?php echo e($type->id); ?>" selected><?php echo e($type->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#sensor-form','/sensors/'.$sensor->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/edit.blade.php ENDPATH**/ ?>