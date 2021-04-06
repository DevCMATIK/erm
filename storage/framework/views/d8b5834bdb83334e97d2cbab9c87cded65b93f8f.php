
<?php $__env->startSection('page-title',$sensor->name.': Alarmas'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/sensors?device_id='.$sensor->device_id,'Sensores','fa-sitemap','btn-info','btn-md'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Creada por','Rango Minimo','Rango Maximo','Activa','Enviar Email','total alarmas','Ultima Alarma','Acciones'],'sensor-alarms/'.$sensor->id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/alarm/index.blade.php ENDPATH**/ ?>