
<?php $__env->startSection('modal-title','Modificar Control'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="control-form">
        <?php echo csrf_field(); ?>

        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($control->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select name="type" class="form-control">
                <?php switch($control->type):
                    case ('text'): ?>
                    <option value="text" selected>Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo">Combo</option>
                    <?php break; ?>
                    <?php case ('radio'): ?>
                    <option value="text">Texto</option>
                    <option value="radio" selected>Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo">Combo</option>
                    <?php break; ?>
                    <?php case ('check'): ?>
                    <option value="text">Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check" selected>CheckBox</option>
                    <option value="combo" >Combo</option>
                    <?php break; ?>
                    <?php case ('combo'): ?>
                    <option value="text">Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo" selected>Combo</option>
                    <?php break; ?>
                <?php endswitch; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valores (opcional)</label>
            <input type="text" class="form-control" id="values" name="values" value="<?php echo e($control->values); ?>">
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Metrica (opcional)</label>
                    <input type="text" class="form-control" id="metric" name="metric" value="<?php echo e($control->metric); ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Es requerido</label>
                    <select name="is_required" class="form-control">
                        <?php if($control->is_required): ?>
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        <?php else: ?>
                            <option value="1">Si</option>
                            <option value="0" selected>No</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#control-form','/check-list-controls/'.$control->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/control/edit.blade.php ENDPATH**/ ?>