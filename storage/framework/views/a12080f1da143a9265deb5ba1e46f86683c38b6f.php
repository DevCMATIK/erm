
<?php $__env->startSection('page-title',$device->name.': Sensores'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/devices?check_point_id='.$device->check_point_id,'Dispositivos','fa-sitemap','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Tipo','Tipo de registro','Direccion','Acciones'],'sensors/'.$device_id,$navBar); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/index.blade.php ENDPATH**/ ?>