
<?php $__env->startSection('modal-title','Modificar tcheck list'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="checkList-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Punto de Control</label>
            <select name="check_point_type_id" class="form-control">
                <option value="" selected="" disabled="">Seleccione...</option>
                <?php $__empty_1 = true; $__currentLoopData = $checkPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkPoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if($checkPoint->id == $checkList->check_point_type_id): ?>
                        <option value="<?php echo e($checkPoint->id); ?>" selected><?php echo e($checkPoint->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($checkPoint->id); ?>"><?php echo e($checkPoint->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" value="<?php echo e($checkList->name); ?>" name="name">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#type-form','/check-lists/'.$checkList->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/edit.blade.php ENDPATH**/ ?>