
<?php $__env->startSection('page-title',$checkPoint->name.': Dispositivos'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/check-points?type='.$checkPoint->type->slug,'Puntos de Control','fa-sitemap','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Id interno','Nombre','tipo','Acciones'],'devices/'.$check_point_id,$navBar); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/index.blade.php ENDPATH**/ ?>