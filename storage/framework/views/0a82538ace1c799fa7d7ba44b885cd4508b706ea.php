
<?php $__env->startSection('modal-title','Modificar Role'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="role-form">
        <?php echo method_field('put'); ?>
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control"  name="slug" id="slug" value="<?php echo e($role->slug); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e($role->name); ?>">
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#role-form','/roles/'.$role->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/role/edit.blade.php ENDPATH**/ ?>