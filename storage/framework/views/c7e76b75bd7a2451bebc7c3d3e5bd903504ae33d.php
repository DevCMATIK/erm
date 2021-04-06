
<?php $__env->startSection('page-title',$type->name.': Interpretadores'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/sensor-types','Tipos de Sensor','fa-sitemap','btn-info','btn-md'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Valor','Nombre','Descripción','Acciones'],'interpreters/'.$type_id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/type/interpreter/index.blade.php ENDPATH**/ ?>