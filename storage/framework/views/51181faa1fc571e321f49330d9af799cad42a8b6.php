
<?php $__env->startSection('page-title','Comandos Ejecutados'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>

    <?php echo makeLink('/export-commands-executed','Exportar','fa-file-excel','btn-success','btn-md'); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Zona','sub zona','Punto de Control','Variable','Orden Ejecutada','Usuario','Fecha'],'commands-executed'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/commands/index.blade.php ENDPATH**/ ?>