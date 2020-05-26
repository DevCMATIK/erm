<div class="row">
    <div class="col-xl-3 rounded-plus" style="font-size: 0.5em" id="accordion">
        <ul class=" list-group bg-white rounded-plus" >
            <?php $__currentLoopData = $subZone->check_points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkPoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($loop->last): ?>
                    <li class="ist-group-item bg-primary  p-0 cursor-pointer rounded-bottom" data-remote="true" href="#collapsed_<?php echo e($checkPoint->id); ?>" id="parent_<?php echo e($checkPoint->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($checkPoint->id); ?>">
                        <h5 class="text-white p-1 py-3 m-0 font-weight-bolder"><?php echo e($checkPoint->type->name); ?> - <?php echo e($checkPoint->name); ?>

                            <a href="javascript:void(0);" onclick="showGrid(<?php echo e($checkPoint->id); ?>);" class="btn-default btn-xs p-1 pull-right"><i class="fal fa-table"></i></a>
                        </h5>
                    </li>
                    <?php if(count($checkPoint->devices) > 0): ?>
                        <ul class="collapse list-group rounded-plus"  id="collapsed_<?php echo e($checkPoint->id); ?>">
                            <?php $__empty_1 = true; $__currentLoopData = $checkPoint->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsedDevice_<?php echo e($device->id); ?>" id="parentDevice_<?php echo e($device->id); ?>" data-toggle="collapse" data-parent="#collapsedDevice_<?php echo e($device->id); ?>">
                                    <h6 class="text-dark p-3 m-0"><?php echo e($device->type->name); ?> - <?php echo e($device->name); ?></h6>
                                </li>
                                <?php if(count($device->sensors) > 0): ?>
                                    <ul class="collapse list-group rounded-plus"  id="collapsedDevice_<?php echo e($device->id); ?>">
                                        <?php $__empty_2 = true; $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <a class="list-group-item pl-6 text-primary fs-md cursor-pointer"
                                               <?php if($sensor->address->configuration_type == 'scale'): ?>
                                               onclick="getScaleForm(<?php echo e($sensor->id); ?>)"
                                               <?php else: ?>
                                               onclick="getBooleanForm(<?php echo e($sensor->id); ?>)"
                                                <?php endif; ?> ><i class="fas fa-cog"></i> <?php echo e($sensor->address->name); ?><?php echo e($sensor->address_number); ?> - <?php echo e($sensor->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            Sin sensores creados.
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                Sin dipositivos creados.
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                <?php else: ?>
                    <li class=" list-group-item p-0 bg-primary cursor-pointer" data-remote="true" href="#collapsed_<?php echo e($checkPoint->id); ?>" id="parent_<?php echo e($checkPoint->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($checkPoint->id); ?>">
                        <h5 class="text-white p-1 py-3 m-0 font-weight-bolder"><?php echo e($checkPoint->type->name); ?> - <?php echo e($checkPoint->name); ?>

                            <a href="javascript:void(0);" onclick="showGrid(<?php echo e($checkPoint->id); ?>);" class="btn-default btn-xs p-1 pull-right"><i class="fal fa-table"></i></a>

                        </h5>

                    </li>
                    <?php if(count($checkPoint->devices) > 0): ?>
                        <ul class="collapse list-group rounded-plus"  id="collapsed_<?php echo e($checkPoint->id); ?>">
                            <?php $__currentLoopData = $checkPoint->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class=" list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsedDevice_<?php echo e($device->id); ?>" id="parentDevice_<?php echo e($device->id); ?>" data-toggle="collapse" data-parent="#collapsedDevice_<?php echo e($device->id); ?>">
                                    <h6 class="text-dark p-3 m-0"><?php echo e($device->type->name); ?> - <?php echo e($device->name); ?></h6>
                                </li>
                                <?php if(count($device->sensors) > 0): ?>
                                    <ul class="collapse list-group rounded-plus"  id="collapsedDevice_<?php echo e($device->id); ?>">
                                        <?php $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="list-group-item pl-6 cursor-pointer text-primary fs-md"
                                               <?php if($sensor->address->configuration_type == 'scale'): ?>
                                               onclick="getScaleForm(<?php echo e($sensor->id); ?>)"
                                               <?php else: ?>
                                               onclick="getBooleanForm(<?php echo e($sensor->id); ?>)"
                                                <?php endif; ?> ><i class="fas fa-cog"></i> <?php echo e($sensor->address->name); ?><?php echo e($sensor->address_number); ?> - <?php echo e($sensor->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div class="col-xl-9" id="sensorForm">

    </div>
</div>
<script>
    function getBooleanForm(sensor) {
        $.get('/getBooleanForm/'+sensor, function(data) {

            $('#sensorForm').html(data);
        });
    }

    function getScaleForm(sensor) {
        $.get('/getScaleForm/'+sensor, function(data) {
            $('#sensorForm').html(data);
        });
    }

    function showGrid(check_point) {
        $.get('/check-point-grid/'+check_point, function(data) {
            $('#sensorForm').html(data);
        });
    }
</script>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/device/sub-zone.blade.php ENDPATH**/ ?>