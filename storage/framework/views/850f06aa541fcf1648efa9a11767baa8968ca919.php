<div class="row my-2">
    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone => $sub_zones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 my-2">
            <h5 class=" py-1 font-weight-bolder border-bottom">
                <?php echo e($zone); ?>

            </h5>
            <?php $__currentLoopData = $sub_zones->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunked_sub_zones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <?php $__currentLoopData = $chunked_sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $check_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="row mt-1 px-2">
                                <?php
                                    if(!isset($check_point['data']['value'])) {
                                        $value = 0;
                                    } else {
                                        $value = $check_point['data']['value'];
                                    }

                                     if(!isset($check_point['data']['unit'])) {
                                            $unit = '%';
                                     } else {
                                            $unit = $check_point['data']['unit'];
                                     }

                                 if(!isset($check_point['data']['color'])) {
                                            $color = 'secondary';
                                     } else {
                                            $color = $check_point['data']['color'];
                                     }

                                ?>
                                <div class="col-xl-8 col-8 py-4 pl-2  bg-gray-200 rounded-plus border-bottom-right-radius-0 border-top-right-radius-0 fs-xl "><?php echo e($check_point['check_point'] ?? null); ?></div>
                                <div class="col-xl-4 col-4  text-center py-4 <?php if($color === null  || $color ?? null == 'success'): ?> bg-primary <?php else: ?> bg-<?php echo e($color ?? 'secondary'); ?> <?php endif; ?> text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0 fs-xl font-weight-bolder" >
                                    <a href="/dashboard/<?php echo e($check_point['sub_zone_id'] ?? 'id'); ?>" class="text-white"><?php echo e(number_format($value,1,',','').' '.$unit); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/statistics/cup-levels.blade.php ENDPATH**/ ?>