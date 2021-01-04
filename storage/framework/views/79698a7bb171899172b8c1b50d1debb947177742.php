<style>
    #d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?> .onoffswitch-inner:before {
        content: "<?php echo e(strtoupper($digital_sensor->sensor->label->on_label)); ?>";
    }
    #d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?> .onoffswitch-inner:after {
        content: "<?php echo e(strtoupper($digital_sensor->sensor->label->off_label)); ?>";
    }
</style>
<?php if($off): ?>
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>"><?php echo e(strtoupper($digital_sensor->sensor->name)); ?></label>
    <div class="d-block <?php if($off): ?> bg-fusion-50 <?php else: ?> bg-<?php echo e($class); ?> <?php endif; ?>  rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>">
        <?php echo e(strtoupper($data)); ?>

    </div>
<?php else: ?>
    <label class="m-0 mb-n1 font-weight-bolder " style="font-size: 0.7em !important;" for="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>"><?php echo e(strtoupper($digital_sensor->sensor->name)); ?></label>
    <div class="onoffswitch" id="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>">
        <input type="checkbox" name="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>" class="onoffswitch-checkbox" id="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>"  <?php if($digital_sensor->sensor->device->report->$address == 1): ?> checked <?php endif; ?>>
        <label class="onoffswitch-label" for="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>
<?php endif; ?>


<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/control/html/digital-output.blade.php ENDPATH**/ ?>