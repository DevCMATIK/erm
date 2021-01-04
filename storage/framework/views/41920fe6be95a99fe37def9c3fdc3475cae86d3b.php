<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white py-1 my-1 text-center">
                <?php echo e(\Illuminate\Support\Str::upper($module->name)); ?>

            </div>
            <div class="card-body">
                <div class="row p-0">
                    <?php $__empty_1 = true; $__currentLoopData = $module->sub_modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php echo $__env->make('inspection.check-list.preview.partials.sub-module', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                No ha creado sub modulos
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observation" class="form-control mt-2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/preview/partials/module.blade.php ENDPATH**/ ?>