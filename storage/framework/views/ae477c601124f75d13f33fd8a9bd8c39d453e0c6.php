<h5 class="mt-3"><?php echo e($sensor->name); ?></h5>
<form id="sensor-range-form">
    <?php echo csrf_field(); ?>
    <div class="row mb-2">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Valor Maximo</label>
                <input type="text" class="form-control" name="max_value" value="<?php echo e($sensor->max_value); ?>">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Escala Por Defecto</label>
                <select name="default_disposition" class="form-control">
                    <?php $__empty_1 = true; $__currentLoopData = $sensor->dispositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disposition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($sensor->default_disposition && $sensor->default_disposition == $disposition->id): ?>
                            <option value="<?php echo e($disposition->id); ?>" selected><?php echo e($disposition->name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($disposition->id); ?>"><?php echo e($disposition->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <option value="" selected="" disabled>No hay opciones</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Texto anterior (antes de valor máximo)</label>
                <input type="text" class="form-control" name="pre_text" value="<?php echo e($sensor->pre_text); ?>">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Texto posterior (despues de la unidad en valor máximo)</label>
                <input type="text" class="form-control" name="post_text" value="<?php echo e($sensor->post_text); ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?php $__empty_1 = true; $__currentLoopData = $sensor->ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <input type="hidden" name="color[]" value="<?php echo e($range->color); ?>">
                <div class="border p-2 bg-<?php echo e($range->color); ?>">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label">Min</label>
                                <input type="text" class="form-control" name="min[]" value="<?php echo e($range->min); ?>">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label">max</label>
                                <input type="text" class="form-control" name="max[]" value="<?php echo e($range->max); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
        </div>
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Guardar Rangos</button>
    </div>
</form>
<?php echo makeValidation('#sensor-range-form','/sensorRanges/'.$sensor->id, ""); ?>


<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/sensor-ranges.blade.php ENDPATH**/ ?>