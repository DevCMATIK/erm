<?php if(isset($is_output) && $is_output === true): ?>
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>"><?php echo e(strtoupper($digital_sensor->sensor->name)); ?></label>
    <div class="d-block bg-<?php echo e($class); ?>  rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>">
        <?php echo e(strtoupper($data)); ?>

    </div>
<?php else: ?>
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>"><?php echo e(strtoupper($digital_sensor->sensor->name)); ?></label>
    <div class="d-block bg-<?php echo e($class); ?> rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>">
        <?php echo e(strtoupper($data)); ?>

    </div>
<?php endif; ?>

<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/html/digital-input.blade.php ENDPATH**/ ?>