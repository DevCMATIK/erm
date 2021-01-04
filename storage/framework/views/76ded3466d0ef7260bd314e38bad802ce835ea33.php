
<?php $__env->startSection('page-title','Tipos de registro'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Id Interno','Nombre','Acciones'],'register-types'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/register-types/index.blade.php ENDPATH**/ ?>