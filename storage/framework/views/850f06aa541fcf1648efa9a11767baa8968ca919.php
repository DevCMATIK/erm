<?php $__currentLoopData = $data->groupBy('zone')->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row my-2">
        <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $zones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 my-2">
                    <h5 class=" py-1 font-weight-bolder border-bottom">
                        <?php echo e($key); ?>

                    </h5>
                <?php $__currentLoopData = $zones->sortBy('sub_zone_position')->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">
                        <?php $__currentLoopData = $chunk_zone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="row mt-1 px-2">
                                    <div class="col-xl-8 col-8 py-4 pl-2  bg-gray-200 rounded-plus border-bottom-right-radius-0 border-top-right-radius-0 fs-xl "><?php echo e($zone['label'] ?? $zone['check_point']); ?></div>
                                    <div class="col-xl-4 col-4  text-center py-4 <?php if($zone['color'] === null || $zone['color'] === 'success'): ?> bg-primary <?php else: ?> bg-<?php echo e($zone['color']); ?> <?php endif; ?> text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0 fs-xl font-weight-bolder" >
                                        <a href="/dashboard/<?php echo e($zone['sub_zone_id']); ?>" class="text-white"><?php echo e($zone['value']); ?>%</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/statistics/cup-levels.blade.php ENDPATH**/ ?>