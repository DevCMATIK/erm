<?php $__env->startSection('page-title',$sensor->name.': Triggers'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/sensors?device_id='.$sensor->device_id,'Sensores','fa-sitemap','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Creador','Sensor Receptor','Cuando sea 1','Cuando sea 0','Rango_minimo','Rango_maximo','en rango max.','Ejecutar Cada','Estado','ultima vez ejecutado','Acciones'],'sensor-triggers/'.$sensor_id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/trigger/index2.blade.php ENDPATH**/ ?>
