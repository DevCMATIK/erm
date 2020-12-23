<?php $__env->startSection('page-title','Zonas'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>

    <?php echo makeRemoteLink('/zoneSerialization','Serializar','fa-list-ol','btn-info','btn-sm'); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','nombre en menú','Sub Zonas','Acciones'],'zones'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/zone/index2.blade.php ENDPATH**/ ?>
