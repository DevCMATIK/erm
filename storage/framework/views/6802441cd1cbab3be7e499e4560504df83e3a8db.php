
<?php $__env->startSection('modal-title','Crear Tipo de dispositivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="address-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="register_type_id">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Configuracion</label>
            <select name="configuration_type" class="form-control">
                <option value="boolean">On/Off</option>
                <option value="scale">Escalas y Rangos</option>
            </select>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#address-form','/addresses', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/address/create.blade.php ENDPATH**/ ?>