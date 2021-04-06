
<?php $__env->startSection('page-title'); ?>
    Descargar Archivos solicitados
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','download'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-12 col-xl-6 col-md-6 col-lg-6  offset-xl-3 offset-md-3 offset-lg-3">
            <div class="alert alert-info">
                <strong>Hola:</strong><br>
                Se han generado los siguientes link de descarga, según la solicitud hecha en : <strong> <?php echo e($reminder->creation_date ?? 'null'); ?></strong><br> por <strong> <?php echo e($reminder->user->first_name); ?> <?php echo e($reminder->user->last_name); ?></strong>
            </div>

            <ul class="list-group">
                <?php $__empty_1 = true; $__currentLoopData = $reminder->files->unique('display_name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <a href="<?php echo e('/download-file/'.$file->id); ?>" class="list-group-item mb-1"><i class="fas fa-file-excel"></i> <?php echo e(\Illuminate\Support\Str::slug($file->display_name,'_').'.xlsx'); ?></a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item">
                        No se han encontrado archivos para descargar...
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/export/index.blade.php ENDPATH**/ ?>