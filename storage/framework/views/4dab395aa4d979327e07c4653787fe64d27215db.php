<?php $__currentLoopData = $subZone->elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('water-management.dashboard.partials.element-electric',['options' => [
		'digital' => 'outputs-as-states'
	]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/views/content-electric.blade.php ENDPATH**/ ?>