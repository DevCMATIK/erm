
<?php $__env->startSection('page-title','Sub Modulos Check List : '.$module->name); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/check-list-modules?check_list_id='.$module->check_list_id,'Modulos','fa-check-square','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Columnas','Acciones'],'check-list-sub-modules/'.$module->id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/module/sub/index2.blade.php ENDPATH**/ ?>
