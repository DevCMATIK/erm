
<?php $__env->startSection('page-title','Alarmas creadas'); ?>
<?php $__env->startSection('page-icon','exclamation-triangle'); ?>

<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Creador','sub_zona','dispositivo','Sensor','Rango Minimo','Rango Maximo','Activa','Enviar Mail','Alarma Activa','Log','Acusar'],'alarms-list'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/alarm/list.blade.php ENDPATH**/ ?>