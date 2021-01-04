
<?php $__env->startSection('page-title','Sequencias de importacion'); ?>
<?php $__env->startSection('page-icon','list-ol'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo makeDefaultView(['nombre','Modulos a importar','Acciones'],'queueImports'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/queue/index.blade.php ENDPATH**/ ?>