<?php $__env->startSection('page-title','Tipos de Sensor'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Intervalo','Min Value','Max Value','Acciones'],'sensor-types'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/type/index.blade.php ENDPATH**/ ?>