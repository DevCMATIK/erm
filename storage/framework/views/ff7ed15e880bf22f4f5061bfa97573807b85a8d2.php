<div class="col-xl-<?php echo e(12 / $columns); ?>" id="element_<?php echo e($element->id); ?>">

    <?php $__currentLoopData = $element->sub_elements->groupBy(function($q){
        return $q->check_point_id;
    }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('water-management.dashboard.partials.sub-element', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/partials/element.blade.php ENDPATH**/ ?>