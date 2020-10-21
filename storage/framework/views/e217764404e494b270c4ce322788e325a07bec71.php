<?php $__env->startSection('page-title','Roles'); ?>
<?php $__env->startSection('page-icon','key'); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Slug','Nombre','Acciones'],'roles'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/role/index.blade.php ENDPATH**/ ?>