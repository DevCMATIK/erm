<?php $__env->startSection('page-title','Usuarios'); ?>
<?php $__env->startSection('page-icon','users'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo makeDefaultView(['Nombre','apellido','email','Telefono','Acciones'],'users'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/user/index.blade.php ENDPATH**/ ?>