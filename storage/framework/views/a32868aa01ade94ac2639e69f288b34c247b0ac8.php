<div class="form-group  m-0 rounded-top">
    <input type="text" class="form-control form-control-lg shadow-inset-2 m-0" id="js_list_accordion_filter_check_point" placeholder="Filtrar Puntos de control ">
</div>
<div id="js_list_accordion_check_points" class="accordion accordion-hover accordion-clean">
    <?php $__currentLoopData = $check_points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $check_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card border-top-left-radius-0 border-top-right-radius-0">
            <div class="card-header ">
                <a href="javascript:void(0);"
                   class="card-title collapsed"
                   data-toggle="collapse"
                   data-target="#sub_zone_list_<?php echo e($check_point->id); ?>"
                   aria-expanded="false"
                   data-filter-tags="<?php echo e(strtolower($check_point->name)); ?> <?php $__currentLoopData = $check_point->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e(strtolower($device->name)); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                    <i class="fal fa-filter width-2 fs-xl"></i>
                    <?php echo e($check_point->sub_zones->first()->name.' - '.$check_point->name); ?> <div class="ml-3" id="header_<?php echo e($check_point->id); ?>"></div>
                    <span class="ml-auto">
                                            <span class="collapsed-reveal">
                                                <i class="fal fa-chevron-up fs-xl"></i>
                                            </span>
                                            <span class="collapsed-hidden">
                                                <i class="fal fa-chevron-down fs-xl"></i>
                                            </span>
                                        </span>
                </a>
            </div>
            <div id="sub_zone_list_<?php echo e($check_point->id); ?>" class="collapse"  data-parent="#js_list_accordion_check_points">
                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $check_point->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item cursor-pointer" id="<?php echo e($check_point->id); ?>_<?php echo e($sensor->id); ?>" data-remote="true" href="#collapsed_<?php echo e($sensor->id); ?>" id="parent_<?php echo e($check_point->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($check_point->id); ?>">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input sensors" value="<?php echo e($sensor->id); ?>" name="sensors[]">
                                        <span class="custom-control-label"><?php echo e($sensor->name); ?></span>
                                    </label>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<span class="filter-message js-filter-message"></span>
<script>
    $(document).ready(function(){
        initApp.listFilter($('#js_list_accordion_check_points'), $('#js_list_accordion_filter_check_point'));
    });
</script>
<?php /**PATH /shared/httpd/water-management/resources/views/data/exports/check-points.blade.php ENDPATH**/ ?>