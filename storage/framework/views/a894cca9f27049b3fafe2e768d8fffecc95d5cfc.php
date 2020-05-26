
<?php $__env->startSection('modal-title','Modificar Permiso'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="permission-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control"  name="slug" id="slug" value="<?php echo e($permission->slug); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Listado de permisos</label>
                    <textarea name="list" class="form-control" rows="3"><?php echo e($permission->list); ?></textarea>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#permission-form','/permissions/'.$permission->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/permission/edit.blade.php ENDPATH**/ ?>