<a class="d-block  rounded-plus mb-1 px-2 py-1 text-center" href="/getDataAsChart/<?php echo e($analogous->sensor->device_id); ?>/<?php echo e($analogous->sensor->id); ?>"  <?php echo makeLinkRemote(); ?> id="d_<?php echo e($analogous->id); ?>_<?php echo e($analogous->sensor->id); ?>">
    <span class="font-weight-bold text-dark fs-md" ><?php echo e(strtoupper($analogous->sensor->name)); ?></span>
    <?php if($se->device->check_point->type->slug != 'copas'): ?>
        <style>
            .progress-bar {
                width: 120% !important;
            }
        </style>
    <?php endif; ?>

    <?php
        if($analogous->sensor->type->id == 1 && optional($disposition->unit)->name == 'mt') {
            $sensor_mt = true;
        } else {
            $sensor_mt = false;
        }
    ?>
    <div class="progress progress-bar-vertical <?php if($se->device->check_point->type->slug == 'copas'): ?> prog-copa <?php endif; ?> mt-0" style="margin-top: 0px !important;">
        <div class="progress-bar <?php if($off): ?> bg-fusion-50 <?php else: ?> bg-<?php echo e($color); ?> <?php endif; ?>  progress-bar progress-bar-striped <?php if($digital && $digital && $digital->means_up == $digitalValue): ?>  progress-bar-animated  <?php endif; ?> progress-bar-flip-vertical" style="width: 100%; height:<?php echo e($percentaje); ?>%;" role="progressbar">
            <?php if($sensor_mt): ?>
                <h2 class=" mt-n6 text-white "  ><span class="font-weight-bolder " style=" <?php if($data >= 100): ?> font-size: 0.7em <?php else: ?> font-size: 0.8em <?php endif; ?> !important;"><?php echo e(number_format(((float)$analogous->sensor->max_value + (float)$data),$disposition->precision)); ?></span> </h2>
            <?php else: ?>
                <?php if($se->device->check_point->type->slug == 'relevadoras'): ?>
                    <h2 class=" mb-0 text-white"><span class="font-weight-bolder " style=" font-size: 0.7em !important;"><?php echo e(number_format(round($data,1),1)); ?></span> <span class="fs-nano text-white"><?php echo e(strtoupper(optional($disposition->unit)->name)); ?></span> </h2>

                <?php else: ?>
                    <h2 class=" mb-0 text-white"><span class="font-weight-bolder " style=" font-size: 0.8em !important;"><?php echo e(number_format($data,$disposition->precision)); ?></span> <span class="fs-nano text-white"><?php echo e(strtoupper(optional($disposition->unit)->name)); ?></span> </h2>

                <?php endif; ?>
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

    <?php if($se->device->check_point->type->slug == 'copas'): ?>
        <hr>
        <p class="text-center text-muted fs-sm mt-1">
        <?php $__currentLoopData = $analogous->sensor->non_selected_dispositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <?php if($dis && $dis != ''): ?>
                <?php
                       $ingMin = $dis->sensor_min;
                       $ingMax = $dis->sensor_max;
                       $escalaMin = $dis->scale_min;
                       $escalaMax = $dis->scale_max;
                       if($escalaMin == null && $escalaMax == null) {
                           $dat = ($ingMin * $valorReport) + $ingMax;
                       } else {
                           $f1 = $ingMax - $ingMin;
                           $f2 = $escalaMax - $escalaMin;
                           $f3 = $valorReport - $escalaMin;
                           if($f2 == 0) {
                               $dat = ((0)*($f3)) + $ingMin ;
                           } else {
                               if($f1 === 0 || $f2 === 0) {
                                    $dat = ((0)*($f3)) + $ingMin ;
                               } else {
                                    $dat = (($f1/$f2)*($f3)) + $ingMin ;
                               }
                           }
                       }

                        if($dis->unit->name == 'm3') {
                            if($data === 0 || $dat === 0) {
                                $max_vol = 0;
                            } else {
                                $max_vol = $dat * 100 / $data;
                            }

                        }
                ?>
                    <?php echo e(number_format((float)$dat,$dis->precision).' '.strtoupper($dis->unit->name)); ?> <br>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($max_vol) && $max_vol != ''): ?>
                Vol. Max <?php echo e(number_format($max_vol,1,'.','')); ?> M3
            <?php endif; ?>
        </p>
    <?php endif; ?>
</a>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/control/html/column.blade.php ENDPATH**/ ?>