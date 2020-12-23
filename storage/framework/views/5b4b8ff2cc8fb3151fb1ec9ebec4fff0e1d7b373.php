<?php $__env->startSection('page-title','Puntos de Control que reportan a DGA'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Punto de Control','Tipo','Zona','Cantidad de reportes','log'],'check-point/dga-reports'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/check-point/report/index2.blade.php ENDPATH**/ ?>
