
<?php $__env->startSection('page-title','Modulos Check List : '.$checkList->name); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/check-lists','Check Lists','fa-check-square','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Posicion','Acciones'],'check-list-modules/'.$checkList->id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/module/index2.blade.php ENDPATH**/ ?>
