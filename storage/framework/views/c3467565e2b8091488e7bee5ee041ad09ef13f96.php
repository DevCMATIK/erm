
<?php $__env->startSection('page-title','Tipo Registro'); ?>
<?php $__env->startSection('page-icon','arrow-up'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Tipo Registro (ID)','Tipo de Configuracion','Acciones'],'addresses'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/address/index.blade.php ENDPATH**/ ?>