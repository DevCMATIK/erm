
<?php $__empty_1 = true; $__currentLoopData = $subColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="<?php if(count($subColumns) == 1): ?>offset-xl-3 col-xl-6 offset-sm-3 col-sm-6 <?php else: ?> col-xl-<?php echo e(12 / count($subColumns)); ?> <?php endif; ?> p-2">
        <div class="card rounded-plus mb-2">
            <div class="card-body">

                <?php switch(array_values(array_flip($key))[0]):
                    case ('digital'): ?>
                    <div class="row border-bottom pb-2 mb-2">
                        <?php $__currentLoopData = $sub_elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($inputs = $sub_element->digital_sensors->filter(function($item) {
                                 return ($item->use_as_digital_chart == 0 && ($item->sensor->address->slug == 'i' || $item->is_not_an_output == 1));
                            })) > 0): ?>

                                <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-4 col-sm-3 col-md-3 col-xl-4">
                                        <?php echo $__env->make('water-management.dashboard.control.digital-input',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row mt-2">
                        <?php $__currentLoopData = $sub_elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($outputs = $sub_element->digital_sensors->filter(function($item) {
                                return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o' && $item->is_not_an_output != 1);
                            })) > 0): ?>

                                <?php $__currentLoopData = $outputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digital_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                                        <?php echo $__env->make('water-management.dashboard.control.digital-output',['digital_sensor' => $digital_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php break; ?>
                    <?php case ('analogous'): ?>
                    <div class="row">
                        <?php $__currentLoopData = $sub_elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $sub_element->analogous_sensors->where('use_as_chart','<>',1)->chunk(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="<?php if(count($sub_element->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1)) > 6): ?> col-xl-6 <?php else: ?> col <?php endif; ?>">
                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analogous_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php break; ?>
                    <?php case ('graph'): ?>
                    <div class="row">
                        <div class="col-xl-4 offset-xl-4 col-sm-4 offset-sm-4">
                            <?php $__currentLoopData = $sub_elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-xl-12">
        <div class="alert alert-info">
            No ha cargado controles para mostrar.
        </div>
    </div>
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
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/views/device-content.blade.php ENDPATH**/ ?>