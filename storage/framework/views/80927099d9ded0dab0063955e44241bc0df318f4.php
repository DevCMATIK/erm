<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $sub_columns = optional($subColumns->where('sub_element',$sub_element->first()->id)->first())['sub_columns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-12 col-12 col-sm-12 col-md-12 col-xl-12">
            <h5><?php echo e($sub_element->first()->element->name); ?></h5>

            <div class="row">
                <?php $__currentLoopData = $sub_element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $se): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $se->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analogous_sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <div class=" col-sm-12 col-md-12 col-xl-12">
                             <?php echo $__env->make('water-management.dashboard.control.analogous-electric',['analogous_sensor' => $analogous_sensor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                         </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
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
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/sub-element-electric.blade.php ENDPATH**/ ?>