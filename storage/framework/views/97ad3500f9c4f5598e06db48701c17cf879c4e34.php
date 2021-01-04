<div class="form-group input-group-sm mb-1">
    <label class="form-label fs-xs text-muted"><?php echo e(\Illuminate\Support\Str::upper($control->name)); ?></label>
    <select name="<?php echo e(\Illuminate\Support\Str::slug($control->name)); ?>" class="form-control">
        <?php $__currentLoopData = explode(';',$control->values); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e(ucwords($value)); ?>"><?php echo e(ucwords($value)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/preview/partials/controls/combo.blade.php ENDPATH**/ ?>