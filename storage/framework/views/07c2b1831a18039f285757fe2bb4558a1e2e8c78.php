<style>
     #js-nav-menu  .collapse-sign {
        color: #fff !important;
    }
</style>
<ul id="js-nav-menu" class="nav-menu">
    <?php $__currentLoopData = getMainMenuItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($m['class']); ?> text-white">
            <a href="<?php echo e(($m['route'] != '')?route($m['route']):'javascript:void(0);'); ?>">
                <i class="fal fa-<?php echo e($m['icon']); ?> text-white"></i>
                <span class="nav-link-text text-white"><?php echo e($m['name']); ?></span>
            </a>
            <?php if(count($m['children']) > 0): ?>
                <ul>
                    <?php $__currentLoopData = $m['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e($child['class']); ?>">
                            <a href="<?php echo e(($child['route'] != '')?route($child['route']):'javascript:void(0);'); ?>">
                                <?php if($child['icon'] != ''): ?>
                                    <i class="fal fa-<?php echo e($child['icon']); ?> text-white-50"></i>&nbsp;
                                <?php endif; ?>
                                <span class="nav-link-text text-white-50"><?php echo e($child['name']); ?></span>
                            </a>
                            <?php if(count($child['children']) > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $child['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php echo e($childs['class']); ?>">
                                            <a href="<?php echo e(($childs['route'] != '')?route($childs['route']):'javascript:void(0);'); ?>">
                                                <?php if($childs['icon'] != ''): ?>
                                                    <i class="fal fa-<?php echo e($childs['icon']); ?> text-white-50"></i>&nbsp;
                                                <?php endif; ?>
                                                <span class="nav-link-text text-white-50"><?php echo e($childs['name']); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php
        $areas = \App\Domain\Client\Area\Area::whereHas('zones.sub_zones', $filter =  function($query){
           $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['zones.sub_zones' => $filter])->get();
    ?>
    <?php $__currentLoopData = $areas->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php

            $mainZones = $area->zones;
        ?>
        <?php if(isset($mainZones) && count($mainZones) > 0): ?>
            <li>
                <a href="javascript:void(0);">
                    <i class="fal <?php if($loop->first): ?> fa-bolt <?php else: ?> fa-map-marker fa-flip-vertical <?php endif; ?> text-white"></i>
                    <span class="nav-link-text text-white"><?php echo e($area->name); ?></span>
                </a>
                <ul>
                <?php $__currentLoopData = $mainZones->sortBy('position'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($zone->sub_zones) > 0): ?>
                    <li >
                        <a href="javascript:void(0);">
                            <i class="fal <?php echo e($area->icon); ?> text-white" id="zone_a_<?php echo e($zone->id); ?>"></i>
                            <span class="nav-link-text text-white" id="zone_span_<?php echo e($zone->id); ?>"><?php echo e($zone->display_name); ?></span>
                        </a>

                            <ul>
                                <?php if($area->name == 'Energía'): ?>
                                <li>
                                    <a class="nav-link-text text-white-50" id="energy_zone<?php echo e($zone->id); ?>" href="/zone-resume/<?php echo e($zone->id); ?>">
                                        <span class="nav-link-text text-white-50">Resumen Energía</span></a>
                                </li>
                                <?php endif; ?>
                                <?php $__currentLoopData = $zone->sub_zones->sortBy('position'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="nav-link-text text-white-50" id="sub_zone_a_<?php echo e($sub_zone->id); ?>" href="<?php if($area->name == 'Energía'): ?> /dashboard-energy/<?php echo e($sub_zone->id); ?> <?php else: ?> /dashboard/<?php echo e($sub_zone->id); ?> <?php endif; ?>">
                                            <span class="nav-link-text text-white-50"><?php echo e($sub_zone->name); ?></span></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                    </li>
                        <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>



<?php /**PATH /shared/httpd/erm/resources/views/layouts/sections/nav.blade.php ENDPATH**/ ?>