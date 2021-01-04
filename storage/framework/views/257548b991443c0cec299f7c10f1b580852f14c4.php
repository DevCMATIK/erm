
<?php $__env->startSection('modal-title','Modificar Area'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="area-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($area->name); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Icono</label>
            <input type="text" class="form-control" id="icon" name="icon" value="<?php echo e($area->icon); ?>">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#area-form','/areas/'.$area->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/area/edit.blade.php ENDPATH**/ ?>