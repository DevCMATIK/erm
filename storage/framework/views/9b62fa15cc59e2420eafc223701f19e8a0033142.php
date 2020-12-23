
<?php $__env->startSection('page-title','Check Lists'); ?>
<?php $__env->startSection('page-icon','check-square'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Punto de Control','Acciones'],'check-lists'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/index2.blade.php ENDPATH**/ ?>
