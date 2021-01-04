
<?php $__env->startSection('page-title','Puntos de Control'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/check-point-types','Tipos','fa-sitemap','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Tipo','Nombre','Zona(s)','Dispositivos','Acciones'],'check-points/'.$type,$navBar); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/index.blade.php ENDPATH**/ ?>