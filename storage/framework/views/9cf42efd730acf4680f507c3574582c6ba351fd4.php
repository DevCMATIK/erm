
<?php $__env->startSection('modal-title','Crear tipo de check list'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="type-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#type-form','/check-list-types', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/type/create.blade.php ENDPATH**/ ?>