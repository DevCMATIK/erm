<h6 class="fs-sm text-muted"><?php echo e(\Illuminate\Support\Str::upper($control->name)); ?></h6>
<?php $__currentLoopData = explode(';',$control->values); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" value="<?php echo e($value); ?>" id="<?php echo e(\Illuminate\Support\Str::slug($control->name).'-'.\Illuminate\Support\Str::slug($value)); ?>" name="<?php echo e(\Illuminate\Support\Str::slug($control->name)); ?>">
        <label class="custom-control-label fs-xs" for="<?php echo e(\Illuminate\Support\Str::slug($control->name).'-'.\Illuminate\Support\Str::slug($value)); ?>"><?php echo e(ucwords($value)); ?></label>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/preview/partials/controls/radio.blade.php ENDPATH**/ ?>