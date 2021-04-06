<?php
    $off = false;
$states = array();
    foreach($sub_element as $ss){

         if($ss->device->from_bio === 1) {
            $state =  DB::connection('bioseguridad')
                ->table('reports')
                ->where('grd_id',$ss->device->internal_id)
                ->first()->state ?? null;
        } else {
           if($ss->device->from_dpl === 1) {
                $state = DB::connection('dpl')
                    ->table('reports')
                    ->where('grd_id',$ss->device->internal_id)
                    ->first()->state ?? false;
            } else {
               $state = $ss->device->report->state;
            }
        }
        array_push($states,$state);


    }
    $state = array_reverse(\Illuminate\Support\Arr::sort($states))[0] ?? 0;
if($state== 0) {
            $off = true;
        }
?>
<div class="card rounded-plus mb-2 " id="sub_element_<?php echo e($sub_element->first()->id); ?>" style="min-height: 400px;">
    <?php if($sub_element->first()->active_alarm()->first()): ?>
        <script>activeAndNotAccused(<?php echo e($sub_element->first()->id); ?>);</script>
    <?php endif; ?>
    <a href="/dashboard/detail/<?php echo e($sub_element->first()->check_point->id); ?>" class="cursor-pointer card-header p-2 text-center font-weight-bolder uppercase fs-xl <?php if($off): ?> bg-secondary text-white <?php if($sub_element->first()->active_alarm()->first()): ?> bg-danger text-white <?php endif; ?> <?php endif; ?>">
            <?php echo e($sub_element->first()->check_point->name); ?>


    </a>
    <div class="card-body ">
        <div class="row">

            <?php $__empty_1 = true; $__currentLoopData = $sub_columns = optional($subColumns->where('sub_element',$sub_element->first()->id)->first())['sub_columns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <div class="<?php if(count($sub_columns) == 1 || $options['digital'] == 'only-outputs' ): ?> <?php if($options['digital'] == 'only-outputs'): ?> col-xl-12 <?php else: ?>  <?php if(array_values(array_flip($key))[0] == 'graph'): ?> offset-2 col-8 <?php else: ?> offset-xl-4 col-xl-4  <?php endif; ?> <?php endif; ?> <?php else: ?> col-xl-<?php echo e(12 / count($sub_columns)); ?> <?php endif; ?> p-2">
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
                                                <div class="col-6 col-sm-6 col-md-4 col-xl-12">
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
                                   <div class="col-4 col-sm-4 col-md-4 col-xl-12">
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
                                   <div class=" <?php if($se->device->check_point->type->slug == 'copas'): ?>  offset-sm-0 col-sm-12 offset-xs-0 col-xs-12 offset-md-0 col-md-12  offset-xl-0 col-xl-12 <?php else: ?>  <?php if($columns == 2): ?> offset-4 col-4  col-md-2 offset-md-5 col-xl-7 offset-xl-2 <?php else: ?> offset-4 col-4  col-md-4 offset-md-4 col-xl-10 offset-xl-1 <?php endif; ?> <?php endif; ?>">
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
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/sub-element.blade.php ENDPATH**/ ?>