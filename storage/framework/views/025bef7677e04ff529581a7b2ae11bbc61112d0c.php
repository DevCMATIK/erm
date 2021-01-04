<?php if($analogous_sensor->no_chart_needed != 1): ?>
    <a href="/getDataAsChart/<?php echo e($analogous_sensor->sensor->device_id); ?>/<?php echo e($analogous_sensor->sensor->id); ?>"  <?php echo makeLinkRemote(); ?> class="d-block  rounded-plus mb-1 px-2 py-1 text-center" id="d_<?php echo e($analogous_sensor->id); ?>_<?php echo e($analogous_sensor->sensor->id); ?>">
<?php else: ?>
    <div class="d-block  rounded-plus mb-1 px-2 py-1 text-center" id="d_<?php echo e($analogous_sensor->id); ?>_<?php echo e($analogous_sensor->sensor->id); ?>">
<?php endif; ?>
        <h2 class=" mb-0  <?php if($off): ?> text-muted <?php else: ?> text-<?php echo e($color); ?> <?php endif; ?>">
            <?php if(!is_numeric((str_replace(',','.',$data)))): ?>
                <span class="font-weight-bolder " style=" font-size: 0.9em !important;"><?php echo e($data); ?></span>
            <?php else: ?>
                <span class="font-weight-bolder " style=" font-size: 0.9em !important;"><?php echo e($data); ?></span>
                <span class="fs-nano text-dark"><?php echo e(strtoupper(optional(optional($disposition)->unit)->name)); ?></span>
            <?php endif; ?>
        </h2>
        <span  class="font-weight-bold text-dark  fs-nano"><?php echo e($analogous_sensor->sensor->name); ?></span>
<?php if($analogous_sensor->no_chart_needed != 1): ?>
    </a>
<?php else: ?>
    </div>
<?php endif; ?>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/control/html/analogous.blade.php ENDPATH**/ ?>