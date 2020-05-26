
<?php $__env->startSection('page-title','Reportes de Email'); ?>
<?php $__env->startSection('page-icon','envelope'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Nombre','Email','Grupos','Creador','Frecuencia','Ejecutar en','activo','Ultima ejecucion','opciones'],'mail-reports'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/report/index.blade.php ENDPATH**/ ?>