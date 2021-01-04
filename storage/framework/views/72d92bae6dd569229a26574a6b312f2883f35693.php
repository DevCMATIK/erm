
<?php $__env->startSection('modal-icon','fa-list-ol'); ?>
<?php $__env->startSection('modal-title','Modificar Sequencia de importacion'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="queuedImports-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="name" id="name" value="<?php echo e($queue->name); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Modulos de importacion </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <?php $__currentLoopData = $imports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="<?php echo e($i->id); ?>"
                                           <?php if(in_array($i->id,json_decode($queue->imports))): ?> checked="checked" <?php endif; ?>
                                           name="imports[]">
                                    <span class="custom-control-label"><?php echo e($i->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#queuedImports-form','/queuedImports/'.$queue->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','50'); ?>

<?php echo $__env->make('layouts.modal.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/queue/edit.blade.php ENDPATH**/ ?>