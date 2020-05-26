<div class="border p-2 my-1">
    <input type="hidden" name="row_id[]" id="row_<?php echo e($row); ?>" value="<?php echo e($row); ?>">
    <div class="row">
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Nombre Disposicion</label>
                <input type="text" class="form-control" name="name[]" id="name_<?php echo e($row); ?>" value="">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Escala</label>
                <select class="form-control" name="scale_id[]" id="scale_id_<?php echo e($row); ?>">
                    <?php $__currentLoopData = $scales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($scale->id); ?>"><?php echo e($scale->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Unidad de Medida</label>
                <select name="unit_id[]" id="unit_id_<?php echo e($row); ?>"  class="form-control">
                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">N. Decimales</label>
                <input type="text" class="form-control" name="precision[]" id="precision_<?php echo e($row); ?>">
            </div>
        </div>
    </div>
    <div class="row mt-2">



        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Minimo Ing.</label>
                <input type="text" class="form-control" name="sensor_min[]" id="scale_min_<?php echo e($row); ?>">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Maximo Ing.</label>
                <input type="text" class="form-control" name="sensor_max[]" id="scale_max_<?php echo e($row); ?>">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Minimo (Sensor)</label>
                <input type="text" class="form-control" name="scale_min[]" id="sensor_min_<?php echo e($row); ?>">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Maximo (Sensor)</label>
                <input type="text" class="form-control" name="scale_max[]" id="sensor_max_<?php echo e($row); ?>">
            </div>
        </div>
    </div>
</div>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/device/new-scale.blade.php ENDPATH**/ ?>