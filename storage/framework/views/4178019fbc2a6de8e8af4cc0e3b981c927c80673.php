
<?php $__env->startSection('page-title',$sensor->name.': Cronómetros'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Nombre','Valor igual que','Usos','Acciones'],'sensor-chronometers/'.$sensor->id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/chronometer/index.blade.php ENDPATH**/ ?>