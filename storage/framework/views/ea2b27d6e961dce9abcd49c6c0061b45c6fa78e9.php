
<?php $__env->startSection('modal-title','Test Variable'); ?>
<?php $__env->startSection('modal-content'); ?>
    <h5>Sensor: <?php echo e($sensor->name); ?> </h5>
    <p>Full Address: <?php echo e($sensor->full_address); ?> grd_id : <?php echo e($sensor->device->internal_id); ?></p>
    <hr>
    <div class="row">
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3 ">ingMin</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" ><?php echo e($value['ingMin']); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3">ingMax</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" ><?php echo e($value['ingMax']); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3 ">scaleMin</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" ><?php echo e($value['scaleMin'] ?? 'N/A'); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3">scaleMax</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" ><?php echo e($value['scaleMax'] ?? 'N/A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <h5><strong>Valor Leído</strong><br><?php echo e($value['valorReport']); ?></h5>
                        </div>
                        <div class="col-9">
                            <h5><strong>Formula Usada</strong><br><?php echo e($value['formula']); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center fs-xxl p-6 text-white bg-primary">
            <?php echo e($value['data']); ?> <?php echo e(optional(optional($disposition)->unit)->name); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit','.'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/device/value-test.blade.php ENDPATH**/ ?>