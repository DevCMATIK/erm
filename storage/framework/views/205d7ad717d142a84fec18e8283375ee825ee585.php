
<?php $__env->startSection('page-title','Menu principal'); ?>
<?php $__env->startSection('page-icon','bars'); ?>
<?php if(Sentinel::getUser()->hasAccess('menus.serialize')): ?>
<?php $__env->startSection('page-buttons'); ?>

    <?php echo makeRemoteLink('/menuSerialization','Serializar','fa-list-ol','btn-info','btn-sm'); ?>


<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['icono','nombre','ruta','posicion','parent','Acciones'],'menus'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/menu/index2.blade.php ENDPATH**/ ?>
