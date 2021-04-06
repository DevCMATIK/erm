
<?php $__env->startSection('page-title','Dispositivos fuera de línea'); ?>
<?php $__env->startSection('page-icon','power-off'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Zona','Sub_zona','Punto de control','Dipositivo','Fecha Inicio','Tiempo Transcurrido','log'],'clientOfflineDevices'); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        setInterval(function(){tableReload()},60000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/devices/index.blade.php ENDPATH**/ ?>