
<?php $__env->startSection('modal-icon','fa-exclamation-circle'); ?>
<?php $__env->startSection('modal-title','Log de errores'); ?>
<?php $__env->startSection('modal-content'); ?>
	<?php echo includeDT(); ?>

	<a href="/importFile/cleanErrors/<?php echo e($importFile->id); ?>" class="btn btn-primary"> Limpiar Log de Errores</a>
	<div class="table-responsive">

		<?php echo makeTable(['row_num','feedback','data'],$importFile->error_messages->only(['row_num','feedback','data'])->toArray(),'log-error-table'); ?>

	</div>
	<?php echo getSimpleTableScript('log-error-table'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','50'); ?>

<?php echo $__env->make('layouts.modal.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/import-file/errorLog.blade.php ENDPATH**/ ?>