
<div class="card rounded-plus mb-2 " id="sub_element_<?php echo e($sub_element->first()->id); ?>" style="min-height: 400px;">
    <?php if($sub_element->first()->active_alarm()->first()): ?>
        <script>activeAndNotAccused(<?php echo e($sub_element->first()->id); ?>);</script>
    <?php endif; ?>
    <a href="/dashboard/detail/<?php echo e($sub_element->first()->check_point->id); ?>" class="cursor-pointer card-header p-2 text-center font-weight-bolder uppercase fs-xl <?php if($sub_element->first()->active_alarm()->first()): ?> bg-danger text-white <?php endif; ?>">
            <?php echo e($sub_element->first()->check_point->name); ?>

            <?php
            $off = false;
            foreach($sub_element as $ss){
                if($ss->device->report->state == 0) {
                    $off = true;
                }
            }
            ?>
            <i class="fas fa-power-off mt-1 float-right px-2  <?php if(!$off): ?>text-success <?php else: ?> text-secondary <?php endif; ?>" title=" <?php if(!$off): ?> Online <?php else: ?> Offline <?php endif; ?>"></i>
    </a>
    <div class="card-body ">
        <div class="row">

            <?php $__empty_1 = true; $__currentLoopData = $sub_columns = optional($subColumns->where('sub_element',$sub_element->first()->id)->first())['sub_columns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <div class="<?php if(count($sub_columns) == 1 || $options['digital'] == 'only-outputs' ): ?> <?php if($options['digital'] == 'only-outputs'): ?> col-xl-12 <?php else: ?> offset-3 col-6  <?php endif; ?> <?php else: ?> col-xl-<?php echo e(12 / count($sub_columns)); ?> <?php endif; ?> p-2">
                    <?php switch(array_values(array_flip($key))[0]):
                        case ('digital'): ?>
                                <?php if($options['digital'] == 'only-outputs'): ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $sub_element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($se->digital_sensors->filter(function($item) {
                                                return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o');
                                           })->count() == 0): ?>
                                                <script>$('#sub_element_<?php echo e($se->id); ?>').remove()</script>
                                            <?php endif; ?>
                                           <?php $__currentLoopData = $se->digital_sensors->filter(function($item) {
                                                return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o');
                                           })->chunk(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-6">
                                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo $__env->make('water-management.dashboard.control.digital-output',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php elseif($options['digital'] == 'outputs-as-states'): ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $sub_element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <?php $__currentLoopData = $se->digital_sensors->where('use_as_digital_chart','<>',1)->where('show_in_dashboard',1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-4 col-sm-3 col-md-3 col-xl-12">
                                                    <?php echo $__env->make('water-management.dashboard.control.digital-input',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                <?php endif; ?>
                        <?php break; ?>
                        <?php case ('analogous'): ?>
                           <?php if($options['digital'] != 'only-outputs'): ?>
                           <div class="row">
                               <?php $__currentLoopData = $sub_element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <?php $__currentLoopData = $se->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analogous_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <div class="col-4 col-sm-3 col-md-3 col-xl-12">
                                       <?php echo $__env->make('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                   </div>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                           <?php endif; ?>
                        <?php break; ?>
                        <?php case ('graph'): ?>
                            <?php $__currentLoopData = $sub_element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <?php if($options['digital'] != 'only-outputs' && $se->analogous_sensors->where('use_as_chart',1)->where('show_in_dashboard',1)->first()): ?>
                               <div class="row">
                                   <div class=" <?php if($se->device->check_point->type->slug == 'copas'): ?> offset-sm-0 col-sm-12 offset-xs-0 col-xs-12 offset-md-0 col-md-12  offset-xl-0 col-xl-12 <?php else: ?>  offset-4 col-4 col-xl-12 offset-xl-0 <?php endif; ?>">
                                       <?php echo $__env->make('water-management.dashboard.control.column', [
                                      'analogous' => $se->analogous_sensors->where('use_as_chart',1)->where('show_in_dashboard',1)->first(),
                                      'digital' => $se->digital_sensors->where('use_as_digital_chart',1)->where('show_in_dashboard',1)->first(),
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                   </div>
                               </div>

                           <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php break; ?>
                    <?php endswitch; ?>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
               <div class="col-xl-12">
                   <div class="alert alert-info">
                       No hay sensores disponibles.
                   </div>
               </div>
                <script>$('#sub_element_<?php echo e($sub_element->first()->id); ?>').remove()</script>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/partials/sub-element.blade.php ENDPATH**/ ?>