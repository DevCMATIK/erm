
<?php $__env->startSection('modal-title','Crear Usuario'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="user-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="first_name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control"  name="last_name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Telefono EJ: 56956996921 (número completo)</label>
                    <input type="text" class="form-control" name="phone">
                </div>
            </div>
        </div>

        <hr>
        <h5>Roles</h5>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="custom-control custom-checkbox">
                <input type="checkbox"  class="custom-control-input" value="<?php echo e($r->id); ?>" name="roles[]">
                <span class="custom-control-label"><?php echo e($r->name); ?></span>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <hr>
        <h5>Grupos</h5>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="custom-control custom-checkbox">
                <input type="checkbox"  class="custom-control-input" value="<?php echo e($g->id); ?>" name="groups[]">
                <span class="custom-control-label"><?php echo e($g->name); ?></span>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#user-form','/users', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/user/create.blade.php ENDPATH**/ ?>