
<?php $__env->startSection('page-title','Vista Previa'); ?>
<?php $__env->startSection('page-icon','eye'); ?>

<?php $__env->startSection('page-content'); ?>

    <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header text-center">
                  <?php echo e(\Illuminate\Support\Str::upper($checkList->name)); ?>

                  <?php echo makeLink('/check-lists','Check Lists','fa-check-square','btn-info','btn-sm float-right'); ?>

              </div>
              <div class="card-body p-1">
                  <?php $__empty_1 = true; $__currentLoopData = $checkList->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php echo $__env->make('inspection.check-list.preview.partials.module', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="alert alert-info">
                        Debe crear modulos para visualizar mas informacion
                    </div>
                  <?php endif; ?>
              </div>
          </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/preview/index2.blade.php ENDPATH**/ ?>
