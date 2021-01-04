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
        <div class="form-group">
            <label class="form-label">Valor Mínimo</label>
            <input type="text" class="form-control" id="min_value" name="min_value" value="<?php echo e($type->min_value); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Valor máximo</label>
            <input type="text" class="form-control" id="max_value" name="max_value" value="<?php echo e($type->max_value); ?>">
        </div>
        <h5><i class="fas fa-cog"></i> Opciones</h5>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="is_exportable" <?php if($type->is_exportable === 1): ?> checked <?php endif; ?> id="is_exportable" value="1">
            <label class="custom-control-label" for="is_exportable">Exportable</label>
        </div>
        <label class="custom-control custom-switch">
            <input type="checkbox"  class="custom-control-input" value="1" name="apply_to_sensors">
            <span class="custom-control-label">Aplicar los valores a todos los sensores</span>
        </label>

        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input main-control" name="is_dga" <?php if($type->is_dga === 1): ?> checked <?php endif; ?>  id="is_dga" value="1">
            <label class="custom-control-label" for="is_dga">Para DGA</label>
        </div>
        <div class="form-group mt-3">
            <h5><i class="fas fa-th"></i> Tipo de sensor</h5>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input main-control" name="sensor_type" id="level" <?php if($type->sensor_type == 'level'): ?> checked <?php endif; ?>  value="level">
                <label class="custom-control-label" for="level">Es Nivel</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input main-control" name="sensor_type" id="tote" <?php if($type->sensor_type == 'tote'): ?> checked <?php endif; ?>   value="tote">
                <label class="custom-control-label" for="tote">Es Totalizador</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input main-control" name="sensor_type" id="flow"  <?php if($type->sensor_type == 'flow'): ?> checked <?php endif; ?>  value="flow">
                <label class="custom-control-label" for="flow">Es Caudal</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input main-control" name="sensor_type"  id="other" <?php if($type->sensor_type == 'other'): ?> checked <?php endif; ?>   value="other">
                <label class="custom-control-label" for="other">Otro</label>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#type-form','/sensor-types/'.$type->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/type/edit.blade.php ENDPATH**/ ?>