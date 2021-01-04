
<?php $__env->startSection('modal-title','Crear Control'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="control-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="sub_module_id" value="<?php echo e($subModule->id); ?>">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select name="type" class="form-control">
                <option value="text">Texto</option>
                <option value="radio">Radio</option>
                <option value="check">CheckBox</option>
                <option value="combo">Combo</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valores (opcional)</label>
            <input type="text" class="form-control" id="values" name="values">
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Metrica (opcional)</label>
                    <input type="text" class="form-control" id="metric" name="metric">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Es requerido</label>
                    <select name="is_required" class="form-control">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#control-form','/check-list-controls', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/control/create.blade.php ENDPATH**/ ?>