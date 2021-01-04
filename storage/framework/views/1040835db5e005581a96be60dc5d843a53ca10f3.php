<?php $__env->startSection('page-title','Log de emails'); ?>
<?php $__env->startSection('page-icon','envelope'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Mail','identificador','fecha de envio','receptores'],'mail-logs'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/mail/log.blade.php ENDPATH**/ ?>