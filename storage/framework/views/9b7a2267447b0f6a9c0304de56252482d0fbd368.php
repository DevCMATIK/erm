<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $subColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="<?php if(count($subColumns) == 1): ?>offset-xl-3 col-xl-6 offset-sm-3 col-sm-6 <?php else: ?> col-xl-<?php echo e(12 / count($subColumns)); ?> <?php endif; ?> p-2">
                            <?php switch(array_values(array_flip($key))[0]):
                                case ('digital'): ?>
                                <div class="row border-bottom pb-2 mb-2">
                                    <?php $__currentLoopData = $sub_elements->unique('device_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $off = false;

                                        ?>
                                        <?php if(count($inputs = $sub_element->digital_sensors->filter(function($item) {
                                             return ($item->use_as_digital_chart == 0 && ($item->sensor->address->slug == 'i' || $item->is_not_an_output == 1));
                                        })) > 0): ?>

                                            <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-4 col-sm-4 col-md-3 col-xl-4">
                                                    <?php echo $__env->make('water-management.dashboard.control.digital-input',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="row mt-2">
                                    <?php $__currentLoopData = $sub_elements->unique('device_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $off = false;

                                        ?>
                                        <?php if(count($outputs = $sub_element->digital_sensors->filter(function($item) {
                                            return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o' && $item->is_not_an_output != 1);
                                        })) > 0): ?>

                                            <?php $__currentLoopData = $outputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-6 col-sm-6 col-md-6 col-xl-4">
                                                    <?php echo $__env->make('water-management.dashboard.control.digital-output',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <?php break; ?>
                                <?php case ('analogous'): ?>
                                <div class="row">
                                    <?php if($sub_elements->first()->check_point->grids->first()): ?>
                                        <?php
                                            $columns = $sub_elements->first()->check_point->grids->pluck('column')->unique();
                                        ?>
                                        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col">
                                                <?php $__currentLoopData = $sub_elements->first()->check_point->grids()->where('column',$column)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($sensors->sensor_id === null): ?>
                                                        <div class="d-block  rounded-plus mb-1 px-2 py-1 text-center" id="">
                                                            <h2 class=" mb-0  text-white ">
                                                                <span class="font-weight-bolder " style=" font-size: 0.9em !important;">blank</span>
                                                                <span class="fs-nano text-white">b</span>
                                                            </h2>
                                                            <span  class="font-weight-bold text-white  fs-nano">blank</span>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php
                                                            $analogous = $sub_elements->pluck('analogous_sensors')->collapse();
                                                            $analogous_sensor = $analogous->where('sensor_id',$sensors->sensor->id)->first();
                                                        ?>
                                                        <?php echo $__env->make('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $sub_elements->unique('device_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $off = false;

                                            ?>
                                            <?php $__currentLoopData = $sub_element->analogous_sensors->where('use_as_chart','<>',1)->chunk(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="<?php if(count($sub_element->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1)) > 6): ?> col-xl-6 <?php else: ?> col <?php endif; ?>">
                                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analogous_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo $__env->make('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </div>
                                <?php break; ?>
                                <?php case ('graph'): ?>
                                <div class="row">

                                    <div class="<?php if($sub_elements->first()->check_point->type()->first()->slug == 'copas' || $sub_elements->first()->check_point->type()->first()->slug == 'relevadoras'): ?> col-xl-8 offset-xl-2 col-sm-6 offset-sm-3 <?php else: ?> col-xl-4 offset-xl-4 col-sm-4 offset-xl-4 <?php endif; ?> ">
                                        <?php $__currentLoopData = $sub_elements->unique('device_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $off = false;

                                            ?>
                                            <?php echo $__env->make('water-management.dashboard.control.column', [
                                                 'analogous' => $se->analogous_sensors->where('use_as_chart',1)->first(),
                                                 'digital' => $se->digital_sensors->where('use_as_digital_chart',1)->first(),
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <?php break; ?>
                            <?php endswitch; ?>
                        </div>


                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-xl-12">
                            <div class="alert alert-info">
                                No ha cargado controles para mostrar.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($indicators): ?>
    <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card my-2">
                    <div class="card-body">
                        <h5 class="mb-2"><?php echo e($groupName); ?></h5>
                        <div class="row">
                                <?php
                                    $group_count = count($group);
                                ?>
                            <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-xl-<?php echo e(12 / $group_count); ?>">
                                    <div class="px-2 py-1 <?php echo e($item['color']); ?>  rounded overflow-hidden position-relative text-white mb-1 text-center "  >
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                                    <span class="text-white"  id="" >
                                                        <span class="hidden-md-down" style="font-size: 0.7em !important;"><?php echo e($item['value']); ?></span>
                                                        <span class="hidden-lg-up"><?php echo e($item['value']); ?></span>
                                                        <span class="fs-nano">
                                                        <?php echo e($item['suffix']); ?>

                                                        </span>
                                                    </span>
                                                <small class="m-0 l-h-n font-weight-bolder fs-nano"><?php echo e($item['name'].' - '. $item['frame']); ?></small>
                                            </h3>
                                        </div>
                                    </div></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>;
<?php endif; ?>
<script>
    $(document).ready(function()
    {
        $('.onoffswitch input[type="checkbox"]').click(function(e){
            let element = $(this);
            let order;
            e.preventDefault();
            if(element.prop("checked") === true){
                order = 1;
            }
            else if(element.prop("checked") === false){
                order = 0;
            }
            confirmAction('Realmente desea ejecutar el comando?','', sendCommand);

            function sendCommand()
            {
                if(order === 0 ) {
                    element.prop('checked',false);
                } else {
                    element.prop('checked',true);
                }
                $.get('/sendCommand', {
                        element : element.attr('id'),
                        order : order
                    } ,function() {
                        toastr.success('Comando ejecutado');
                    }
                )
            }
        });
    });
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/device-content.blade.php ENDPATH**/ ?>