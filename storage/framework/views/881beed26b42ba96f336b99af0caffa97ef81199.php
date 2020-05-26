
<?php $__env->startSection('modal-title','Modificar Unidad'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="unit-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($unit->name); ?>">
        </div>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#unit-form','/units/'.$unit->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/unit/edit.blade.php ENDPATH**/ ?>