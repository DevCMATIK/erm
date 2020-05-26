<?php $__env->startSection('page-title','Dispositivos fuera de línea'); ?>
<?php $__env->startSection('page-icon','power-off'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Zona','Sub zona','Punto de control','Fecha Inicio','Tiempo Transcurrido'],'clientOfflineDevicesList'); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        setInterval(function(){tableReload()},60000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/devices/list.blade.php ENDPATH**/ ?>