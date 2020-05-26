
<?php $__env->startSection('modal-title','Crear check List'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="checkList-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Punto de Control</label>
            <select name="check_point_type_id" class="form-control">
                <option value="" selected="" disabled="">Seleccione...</option>
                <?php $__empty_1 = true; $__currentLoopData = $checkPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkPoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($checkPoint->id); ?>"><?php echo e($checkPoint->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#checkList-form','/check-lists', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/create.blade.php ENDPATH**/ ?>