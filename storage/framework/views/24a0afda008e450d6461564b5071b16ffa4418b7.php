
<?php $__env->startSection('modal-title','Modificar direccion'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="address-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($address->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="register_type_id" value="<?php echo e($address->register_type_id); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Configuracion</label>
            <select name="configuration_type" class="form-control">
                <?php switch($address->configuration_type):
                    case ('boolean'): ?>
                        <option value="boolean" selected>On/Off</option>
                        <option value="scale">Escalas y Rangos</option>
                    <?php break; ?>
                    <?php case ('scale'): ?>
                        <option value="boolean">On/Off</option>
                        <option value="scale" selected>Escalas y Rangos</option>
                    <?php break; ?>
                <?php endswitch; ?>
            </select>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#address-form','/addresses/'.$address->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/address/edit.blade.php ENDPATH**/ ?>