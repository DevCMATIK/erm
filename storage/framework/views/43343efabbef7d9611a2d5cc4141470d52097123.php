
<?php $__env->startSection('modal-title','Modificar Sub Modulo de check list'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="check-list-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($sub->name); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Columnas</label>
            <select name="columns" class="form-control">
                <?php switch($sub->columns):
                    case (1): ?>
                        <option value="1" selected>1 Columna</option>
                        <option value="2">2 Columnas</option>
                        <option value="3">3 Columnas</option>
                    <?php break; ?>
                    <?php case (2): ?>
                        <option value="1">1 Columna</option>
                        <option value="2" selected>2 Columnas</option>
                        <option value="3">3 Columnas</option>
                    <?php break; ?>
                    <?php case (3): ?>
                        <option value="1">1 Columna</option>
                        <option value="2">2 Columnas</option>
                        <option value="3" selected>3 Columnas</option>
                    <?php break; ?>
                <?php endswitch; ?>
            </select>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#check-list-form','/check-list-sub-modules/'.$sub->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/module/sub/edit.blade.php ENDPATH**/ ?>