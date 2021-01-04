<div class="col-lg-<?php echo e($sub->columns * 4); ?>">
    <?php if(count($sub->controls) > 0): ?>
        <div class="card my-1">
            <?php if($sub->name): ?>
                <div class="card-header bg-primary text-center text-white p-1">
                    <?php echo e(\Illuminate\Support\Str::upper($sub->name)); ?>

                </div>
            <?php endif; ?>
            <div class="card-body p-1">
                <?php echo $__env->make('inspection.check-list.preview.partials.controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/preview/partials/sub-module.blade.php ENDPATH**/ ?>