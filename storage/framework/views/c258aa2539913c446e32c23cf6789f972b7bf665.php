<?php if($check_point): ?>
    <?php $__empty_1 = true; $__currentLoopData = $sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" value="<?php echo e($sub_zone->id); ?>" class="custom-control-input" id="check_<?php echo e($sub_zone->id); ?>" name="sub_zone_id[]" <?php if($check_point->sub_zones->contains($sub_zone->id)): ?> checked <?php endif; ?>>
            <label class="custom-control-label fs-xs" for="check_<?php echo e($sub_zone->id); ?>"><?php echo e($sub_zone->name); ?></label>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-info">
            No ha creado sub Zonas
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php $__empty_1 = true; $__currentLoopData = $sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" value="<?php echo e($sub_zone->id); ?>" class="custom-control-input" id="check_<?php echo e($sub_zone->id); ?>" name="sub_zone_id[]">
            <label class="custom-control-label fs-xs" for="check_<?php echo e($sub_zone->id); ?>"><?php echo e($sub_zone->name); ?></label>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-info">
            No ha creado sub Zonas
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /shared/httpd/water-management/resources/views/client/check-point/sub-zones.blade.php ENDPATH**/ ?>