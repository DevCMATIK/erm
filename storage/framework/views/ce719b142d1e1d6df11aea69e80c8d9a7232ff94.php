
<?php $__env->startSection('page-title','Listado de Cambios'); ?>
<?php $__env->startSection('page-icon','users'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Usuario','Descripción','Tabla','Valores_antiguos','Nuevos Valores','Fecha'],'change-logs'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/change-log/index.blade.php ENDPATH**/ ?>