<?php $__env->startSection('modal-title','Modificar Zona'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="zone-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($zone->name); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Nombre en Menu</label>
            <input type="text" class="form-control" id="display_name" name="display_name" value="<?php echo e($zone->display_name); ?>">
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#zone-form','/zones/'.$zone->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/zone/edit.blade.php ENDPATH**/ ?>