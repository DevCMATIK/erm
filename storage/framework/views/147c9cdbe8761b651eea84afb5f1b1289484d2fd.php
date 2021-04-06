
<?php $__env->startSection('modal-title','Crear Area de produccion'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo includeCss('plugins/duallistbox/duallistbox.css'); ?>

    <?php echo includeScript('plugins/duallistbox/duallistbox.js'); ?>


                        <form id="production-area-users">
                            <?php echo csrf_field(); ?>
                            <select name="users[]" id="usersAreaList" class="form-control" multiple>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($production_area->users->contains($user->id)): ?>
                                        <option value="<?php echo e($user->id); ?>" selected><?php echo e($user->full_name); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo e($user->id); ?>" ><?php echo e($user->full_name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>

    <script>
        $('#usersAreaList').bootstrapDualListbox({
            nonSelectedListLabel: 'Listado de Usuarios',
            selectedListLabel: 'Usuarios del Área',
            preserveSelectionOnMove: 'moved'
        });


    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#production-area-users','/production-area/'.$production_area->id.'/users', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/production-area/users.blade.php ENDPATH**/ ?>