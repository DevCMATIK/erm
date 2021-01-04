
<?php $__env->startSection('modal-title','Crear Escala'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="scale-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Minimo</label>
            <input type="text" class="form-control"  name="min">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Maximo</label>
            <input type="text" class="form-control" name="max">
        </div>
        <div class="form-group">
            <label class="form-label">Decimales</label>
            <input type="text" class="form-control"  name="precision">
        </div>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#scale-form','/scales', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/scale/create.blade.php ENDPATH**/ ?>