
<?php $__env->startSection('page-title','Imports'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['nombre','slug','descripción','role_necesario','Acciones'],'imports'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/index.blade.php ENDPATH**/ ?>