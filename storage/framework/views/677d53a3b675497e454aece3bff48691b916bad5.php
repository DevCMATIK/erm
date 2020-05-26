
<?php $__env->startSection('page-title','Escalas'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Rango min.','Rango max.','Decimales','Acciones'],'scales'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/scale/index.blade.php ENDPATH**/ ?>