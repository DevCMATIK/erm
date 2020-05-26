
<?php $__env->startSection('page-title','Sub Zonas'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/zones','Zonas','fa-sitemap','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Zona','Acciones'],'sub-zones/'.$zone); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/zone/sub/index.blade.php ENDPATH**/ ?>