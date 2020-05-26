
	<?php $__currentLoopData = $imports->chunk(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $import): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col">
					<div class="card">
						<div class="card-header">
							<b><?php echo e(ucwords($import->name)); ?></b>
						</div>
						<div class="card-body">
							<?php echo e(substr($import->description,0,20)); ?>...
						</div>
						<div class="card-footer">
							<a href="importFile/<?php echo e($import->slug); ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-upload"></i> Importar</a>
						</div>
					</div>
				</div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <hr>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php /**PATH /shared/httpd/water-management/resources/views/system/import/show/item.blade.php ENDPATH**/ ?>