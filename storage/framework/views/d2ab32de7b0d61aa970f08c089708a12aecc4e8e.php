
<?php $__env->startSection('page-title','Listado de Descargas por correo'); ?>
<?php $__env->startSection('page-icon','list'); ?>

<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Fecha','Usuario','Sensores','Fecha inicio','fecha termino'],'userDownloads'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/download/index.blade.php ENDPATH**/ ?>