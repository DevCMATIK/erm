<h5>Sensores seleccionados</h5>

<?php $__empty_1 = true; $__currentLoopData = $sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <div class="list-group-item py-1 px-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" checked class="custom-control-input" value="<?php echo e($sensor->id); ?>" name="sensor_id[]">
            <span class="custom-control-label"><?php echo e($sensor->device->sub_element->first()->element->sub_zone->name); ?> -
        <?php echo e($sensor->device->name); ?> -
        <?php echo e($sensor->full_address); ?></span>
        </label>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>No ha seleccionado sensores</p>
<?php endif; ?>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/report/sensor-list.blade.php ENDPATH**/ ?>