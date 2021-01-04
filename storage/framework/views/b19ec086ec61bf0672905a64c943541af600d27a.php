<div class="modal fade js-modal-messenger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-left modal-sm">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">Puntos de Control</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">
                <div class="row">
                    <div class="col">
                        <ul class="list-group w-100 rounded-0" >
                            <?php $__currentLoopData = $subZone->sub_elements->groupBy(function($q){
                           return $q->check_point_id;
                       }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if($sub->first()->check_point_id == $check_point): ?>
                                    <a class=" cursor-pointer list-group-item active text-white my-1"  href="/dashboard/detail/<?php echo e($sub->first()->check_point->id); ?>"  ><?php echo e($sub->first()->check_point->name); ?></a>
                                <?php else: ?>
                                    <a class="cursor-pointer list-group-item my-1 text-dark"   href="/dashboard/detail/<?php echo e($sub->first()->check_point->id); ?>"  ><?php echo e($sub->first()->check_point->name); ?></a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade js-modal-kpi" tabindex="-1" role="dialog" id="modal-kpi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-md">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">KPI</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">
                <?php if($flow || $totalizer || $costs): ?>
                    <?php if($flow): ?>
                        <div class="row mb-4" id="kpi-flow-content">
                            <?php echo $__env->make('water-management.dashboard.partials.kpi.flow-kpi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($totalizer): ?>
                        <div class="row mt-3 mb-4" id="kpi-totalizer-content">
                            <?php echo $__env->make('water-management.dashboard.partials.kpi.totalizer-kpi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($costs): ?>
                            <?php $__currentLoopData = $costs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row mb-4">
                                    <?php echo $__env->make('water-management.dashboard.partials.kpi.cost-kpi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        El Punto de control no posee KPI asociados
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/navigation.blade.php ENDPATH**/ ?>