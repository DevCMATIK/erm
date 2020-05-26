<?php $__env->startSection('modal-title','Modificar Tipo de Sensor'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="type-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($type->name); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Intervalo</label>
            <select name="interval" class="form-control">
                <?php switch($type->interval):
                    case (1): ?>
                    <option value="1" selected>Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    <?php break; ?>
                    <?php case (5): ?>

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5" selected>Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    <?php break; ?>
                    <?php case (10): ?>

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10" selected>Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    <?php break; ?>
                    <?php case (15): ?>

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15" selected>Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    <?php break; ?>
                    <?php case (30): ?>

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30" selected>Cada 30 Minutos</option>
                    <option value="60">Cada 60 Minutos</option>
                    <?php break; ?>
                    <?php case (60): ?>

                    <option value="1">Cada 1 Minuto</option>
                    <option value="5">Cada 5 Minutos</option>
                    <option value="10">Cada 10 Minutos</option>
                    <option value="15">Cada 15 Minutos</option>
                    <option value="30">Cada 30 Minutos</option>
                    <option value="60" selected>Cada 60 Minutos</option>
                    <?php break; ?>
                <?php endswitch; ?>
            </select>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#type-form','/sensor-types/'.$type->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/type/edit.blade.php ENDPATH**/ ?>