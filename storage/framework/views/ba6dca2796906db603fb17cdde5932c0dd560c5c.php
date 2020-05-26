<?php $__currentLoopData = $sub->controls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $control): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php switch($control->type):
        case ('text'): ?>
            <?php echo $__env->make('inspection.check-list.preview.partials.controls.text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php break; ?>
        <?php case ('radio'): ?>
            <?php echo $__env->make('inspection.check-list.preview.partials.controls.radio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php break; ?>
        <?php case ('check'): ?>
            <?php echo $__env->make('inspection.check-list.preview.partials.controls.check', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php break; ?>
        <?php case ('combo'): ?>
            <?php echo $__env->make('inspection.check-list.preview.partials.controls.combo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php break; ?>
    <?php endswitch; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/preview/partials/controls.blade.php ENDPATH**/ ?>