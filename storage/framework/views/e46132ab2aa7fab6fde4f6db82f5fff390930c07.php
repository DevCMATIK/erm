
<?php $__env->startSection('page-title','Administrar Grupos de '.$user->full_name); ?>
<?php $__env->startSection('page-icon','cog'); ?>
<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/duallistbox/duallistbox.css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/duallistbox/duallistbox.js'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-description'); ?>
    <?php echo makeLink('/users','Volver a usuarios','fa-arrow-left', 'btn-primary float-right'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        $('#usersGroupList').bootstrapDualListbox({
            nonSelectedListLabel: 'Listado de grupos',
            selectedListLabel: 'Grupos del usuario',
            preserveSelectionOnMove: 'moved'
        });


    </script>
    <?php echo makeValidation('#user-group-form','/handleUserGroups/'.$user->id,''); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Administrar Grupos
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form id="user-group-form">
                            <?php echo csrf_field(); ?>
                            <select name="groups[]" id="usersGroupList" class="form-control" multiple>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($user->groups->contains($group)): ?>
                                        <option value="<?php echo e($group->id); ?>" selected><?php echo e($group->name); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo e($group->id); ?>" ><?php echo e($group->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-info btn-block">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/user/group/index.blade.php ENDPATH**/ ?>