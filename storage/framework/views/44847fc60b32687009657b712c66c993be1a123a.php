<style>
    #d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?> .onoffswitch-inner:before {
        content: "<?php echo e(strtoupper($digital_sensor->sensor->label->on_label)); ?>";
    }
    #d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?> .onoffswitch-inner:after {
        content: "<?php echo e(strtoupper($digital_sensor->sensor->label->off_label)); ?>";
    }
</style>
<label class="m-0 mb-n1 font-weight-bolder " style="font-size: 0.7em !important;" for="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>"><?php echo e(strtoupper($digital_sensor->sensor->name)); ?></label>
<div class="onoffswitch" id="d_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>">
        <input type="checkbox" name="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>" class="onoffswitch-checkbox" id="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>"  <?php if($digital_sensor->sensor->device->report->$address == 1): ?> checked <?php endif; ?>>
        <label class="onoffswitch-label" for="switch_<?php echo e($digital_sensor->sensor->device->internal_id); ?>_<?php echo e($digital_sensor->id); ?>_<?php echo e($digital_sensor->sensor->id); ?>_<?php echo e($digital_sensor->sensor->address->name); ?>_<?php echo e($digital_sensor->sensor->address_number); ?>">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
</div>

<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/html/digital-output.blade.php ENDPATH**/ ?>