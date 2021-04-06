
<?php $__env->startSection('page-title','Triggers'); ?>
<?php $__env->startSection('page-icon','database'); ?>

<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Creador','sub zona','Sensor Receptor','Sensor Ejecutor','Cuando sea 1','Cuando sea 0','Rango_minimo','Rango_maximo','en rango max','Ejecutar Cada','ultima vez ejecutado','Acciones'],'triggers-list'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/trigger/list.blade.php ENDPATH**/ ?>