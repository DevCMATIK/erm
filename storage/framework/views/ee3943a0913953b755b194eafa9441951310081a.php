
<?php $__env->startSection('page-title','Tipos de puntos de control'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Nombre','Puntos de Control','Acciones'],'check-point-types',$navBar); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/check-point/type/index.blade.php ENDPATH**/ ?>