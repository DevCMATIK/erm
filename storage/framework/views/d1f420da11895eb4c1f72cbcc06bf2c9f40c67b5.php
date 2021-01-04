<div class="row">
    <div  class="col-xl-2" id="devices-list">
        <?php $__empty_1 = true; $__currentLoopData = $subZone->check_points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $check_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php if(!$subZone->sub_elements->contains('check_point_id',$check_point->id)): ?>
                    <ul id="device_<?php echo e($check_point->id); ?>" class="list-group">
                        <li class="list-group-item cursor-move" style="width: 100%">
                            <?php echo e($check_point->name); ?>

                        </li>
                    </ul>
                <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="alert alert-danger">
                No ha cargado puntos de control a la sub zona.
            </div>
        <?php endif; ?>

    </div>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/partials/available-devices.blade.php ENDPATH**/ ?>