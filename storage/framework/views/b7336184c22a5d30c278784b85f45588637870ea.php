<ul class="list-group bg-white rounded-plus m-2">
    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->last): ?>
            <li class="list-group-item p-0 cursor-pointer rounded-bottom" data-remote="true" href="#collapsed_<?php echo e($zone->id); ?>" id="parent_<?php echo e($zone->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($zone->id); ?>">
                <h5 class="text-dark p-3 m-0 font-weight-bolder" id="zone_a_<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></h5>
            </li>
            <?php if(count($zone->sub_zones) > 0): ?>
                <ul class="collapse list-group rounded-plus"  id="collapsed_<?php echo e($zone->id); ?>">
                    <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($sub_zone->configuration && Sentinel::getUser()->inSubZone($sub_zone->id)): ?>
                            <a class="list-group-item pl-6 text-primary fs-xl   " id="sub_zone_a_<?php echo e($sub_zone->id); ?>" href="/dashboard/<?php echo e($sub_zone->id); ?>"><i class="fas fa-chart-bar"></i> <?php echo e($sub_zone->name); ?></a>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <li class="list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsed_<?php echo e($zone->id); ?>" id="parent_<?php echo e($zone->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($zone->id); ?>">
                <h5 class="text-dark p-3 m-0 font-weight-bolder"><?php echo e($zone->name); ?></h5>
            </li>
            <?php if(count($zone->sub_zones) > 0): ?>
                <ul class="collapse list-group rounded-plus"  id="collapsed_<?php echo e($zone->id); ?>">
                    <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($sub_zone->configuration && Sentinel::getUser()->inSubZone($sub_zone->id)): ?>
                            <a class="list-group-item pl-6 text-primary fs-xl" id="sub_zone_a_<?php echo e($sub_zone->id); ?>" href="/dashboard/<?php echo e($sub_zone->id); ?>"><i class="fas fa-chart-bar"></i> <?php echo e($sub_zone->name); ?></a>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/partials/zones-nav.blade.php ENDPATH**/ ?>