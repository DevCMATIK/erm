<a class="d-block  rounded-plus mb-1 px-2 py-1 text-center" href="/getDataAsChart/<?php echo e($analogous->sensor->device_id); ?>/<?php echo e($analogous->sensor->id); ?>"  <?php echo makeLinkRemote(); ?> id="d_<?php echo e($analogous->id); ?>_<?php echo e($analogous->sensor->id); ?>">
    <span class="font-weight-bold text-dark fs-md" ><?php echo e(strtoupper($analogous->sensor->name)); ?></span>
    <?php if($se->device->check_point->type->slug != 'copas'): ?>
        <style>

        </style>
    <?php endif; ?>
    <?php
        if($analogous->sensor->type->id == 1 && $disposition->unit->name == 'mt') {
            $sensor_mt = true;
            $percentaje = $percentaje* (-1);
        } else {
            $sensor_mt = false;
        }
    ?>
    <div class="progress progress-bar-vertical <?php if($se->device->check_point->type->slug == 'copas'): ?> prog-copa <?php endif; ?> mt-0" style="margin-top: 0px !important;">

        <div class="progress-bar bg-<?php echo e($color); ?>  progress-bar progress-bar-striped <?php if($digital && $digital && $digital->means_up == $digitalValue): ?>  progress-bar-animated  <?php endif; ?> progress-bar-flip-vertical" style="width: 100%; height:<?php echo e($percentaje); ?>%;" role="progressbar">
            <?php if($sensor_mt): ?>
                <h2 class=" mt-n6 text-white "  ><span class="font-weight-bolder " style=" font-size: 0.8em !important;"><?php echo e(number_format(((float)$analogous->sensor->max_value + (float)$data),$disposition->precision)); ?></span> <span class="fs-nano text-white"><?php echo e(strtoupper($disposition->unit->name)); ?></span> </h2>
            <?php else: ?>
                <h2 class=" mb-0 text-white"><span class="font-weight-bolder " style=" font-size: 0.8em !important;"><?php echo e(number_format($data,$disposition->precision)); ?></span> <span class="fs-nano text-white"><?php echo e(strtoupper($disposition->unit->name)); ?></span> </h2>
            <?php endif; ?>
        </div>
    </div>
    <?php if($disposition->unit->name != '%'): ?>
        <span class="fs-nano m-0 mb-1 text-dark"><?php echo e($analogous->sensor->max_value); ?> <?php echo e(strtoupper($disposition->unit->name)); ?></span><br>
    <?php endif; ?>
    <?php if($digital && $digital && $digital->means_down == $digitalValue): ?>
        <i class="fas fa-caret-down fa-2x text-dark"></i>
        <span class="d-block font-weight-bold fs-nano text-dark "><?php echo e(strtoupper($digital_label)); ?></span>
    <?php else: ?>
        <i class="fas fa-caret-up fa-2x text-dark"></i>
        <span class=" d-block font-weight-bold fs-nano  text-dark"><?php echo e(strtoupper($digital_label)); ?></span>
    <?php endif; ?>
</a>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/html/column.blade.php ENDPATH**/ ?>