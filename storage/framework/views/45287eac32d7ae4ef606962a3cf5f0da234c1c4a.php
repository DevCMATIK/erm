
<?php $__env->startSection('modal-title','Crear Sub Zona'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="sub-zone-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="zone" value="<?php echo e($zone); ?>">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#sub-zone-form','/sub-zones', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/zone/sub/create.blade.php ENDPATH**/ ?>