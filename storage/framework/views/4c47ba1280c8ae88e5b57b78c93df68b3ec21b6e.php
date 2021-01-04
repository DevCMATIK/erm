
<?php $__env->startSection('modal-title','Crear Modulo de Check List'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="check-list-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="check_list_id" value="<?php echo e($checkList->id); ?>">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#check-list-form','/check-list-modules', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/module/create.blade.php ENDPATH**/ ?>