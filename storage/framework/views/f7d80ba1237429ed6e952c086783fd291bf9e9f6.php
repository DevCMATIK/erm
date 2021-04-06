
<?php $__env->startSection('mail-header'); ?>
    <?php echo $header; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('mail-content'); ?>
    <?php echo $body; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/emails/dynamic.blade.php ENDPATH**/ ?>