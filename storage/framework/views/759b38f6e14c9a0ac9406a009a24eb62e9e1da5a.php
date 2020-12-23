
<?php $__env->startSection('page-title','Permisos'); ?>
<?php $__env->startSection('page-icon','th-list'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Slug','Nombre','Acciones'],'permissions'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/permission/index2.blade.php ENDPATH**/ ?>
