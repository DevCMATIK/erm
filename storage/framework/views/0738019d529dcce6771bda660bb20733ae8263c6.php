<div class="form-group input-group-sm mb-1">
    <label class="form-label fs-xs text-muted"><?php echo e(\Illuminate\Support\Str::upper($control->name)); ?></label>
    <input type="text" class="form-control" name="<?php echo e(\Illuminate\Support\Str::slug($control->name)); ?>">
</div>
<?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/preview/partials/controls/text.blade.php ENDPATH**/ ?>