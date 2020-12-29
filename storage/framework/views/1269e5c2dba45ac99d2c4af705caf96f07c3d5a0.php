
<?php $__env->startSection('page-title','Areas'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Zonas','icono','Acciones'],'areas'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/area/index2.blade.php ENDPATH**/ ?>
