
<?php $__env->startSection('page-title','Tipos de Check List'); ?>
<?php $__env->startSection('page-icon','check-square'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Acciones'],'check-list-types'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/inspection/check-list/type/index.blade.php ENDPATH**/ ?>