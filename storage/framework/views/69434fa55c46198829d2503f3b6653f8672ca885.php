
<?php $__env->startSection('page-title','Import: ' . $import->name); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-buttons'); ?>
    <?php echo makeLink('/getImports','Volver','fa-arrow-left','btn-info'); ?>

    <?php echo makeRemoteLink('/importFile/'.$import->slug.'/upload','Subir Archivo','fa-upload'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<?php echo makeDefaultView(['Usuario','Archivo','extensión','Status','Subido el','Acciones'],'import-files/'.$import->slug); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/import/import-file/index.blade.php ENDPATH**/ ?>