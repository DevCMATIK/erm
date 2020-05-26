
<?php $__env->startSection('modal-title','Crear Menu'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="menu-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Icono</label>
                    <input type="text" class="form-control"  name="icon" id="icon">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre del Item</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre de la Ruta</label>
                    <input type="text" class="form-control" id="route" name="route">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Item Padre</label>
                    <select class="form-control m-b" name="parent_id" id="parent_id">
                        <option value="">Item Principal</option>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Roles </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="<?php echo e($r->slug); ?>" name="roles[]">
                                    <span class="custom-control-label"><?php echo e($r->name); ?></span>
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
    <?php echo makeValidation('#menu-form','/menus', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/menu/create.blade.php ENDPATH**/ ?>