
<?php $__env->startSection('page-title','Unidades'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Acciones'],'units'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/unit/index.blade.php ENDPATH**/ ?>