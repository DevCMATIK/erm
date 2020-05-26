
<?php $__env->startSection('modal-title','Modificar Sub Zona'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="sub-zone-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($zone->name); ?>">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#sub-zone-form','/sub-zones/'.$zone->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/zone/sub/edit.blade.php ENDPATH**/ ?>