
<?php $__env->startSection('modal-title','Roles del usuario: '.$user->full_name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="userRoles-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Roles </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($user->inRole($r->slug)): ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" checked="checked" class="custom-control-input" value="<?php echo e($r->slug); ?>" name="roles[]">
                                        <span class="custom-control-label"><?php echo e($r->name); ?></span>
                                    </label>
                                <?php else: ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo e($r->slug); ?>" name="roles[]">
                                        <span class="custom-control-label"><?php echo e($r->name); ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#userRoles-form','/userRoles/'.$user->id, "closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','20'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/user/role/index2.blade.php ENDPATH**/ ?>
