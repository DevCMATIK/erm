
<?php $__env->startSection('page-title','Controles Check List : '.$subModule->name); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/check-list-sub-modules?module='.$subModule->module_id,'Sub Modulos','fa-check-square','btn-info','btn-sm'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Nombre','Tipo','Valores','Metrica','Requerido','Acciones'],'check-list-controls/'.$subModule->id); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/inspection/check-list/control/index2.blade.php ENDPATH**/ ?>
