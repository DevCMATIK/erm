
<?php $__env->startSection('modal-title','Modificar Menu'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="menu-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Icono</label>
                    <input type="text" class="form-control"  name="icon" id="icon" value="<?php echo e($menu->icon); ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre del Item</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e($menu->name); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre de la Ruta</label>
                    <input type="text" class="form-control" id="route" name="route" value="<?php echo e($menu->route); ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Item Padre</label>
                    <select class="form-control m-b" name="parent_id" id="parent_id">
                        <?php if($menu->parent_id == null): ?>
                            <option value="" selected >Item Principal</option>
                        <?php else: ?>
                            <option value="">Item Principal</option>
                        <?php endif; ?>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($m->id == $menu->parent_id): ?>
                                <option value="<?php echo e($m->id); ?>" selected><?php echo e($m->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option>
                            <?php endif; ?>
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
                                <?php if(in_array($r->slug,$menu->entityRolesAsArray())): ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="<?php echo e($r->slug); ?>" name="roles[]">
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
    <?php echo makeValidation('#menu-form','/menus/'.$menu->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/menu/edit.blade.php ENDPATH**/ ?>