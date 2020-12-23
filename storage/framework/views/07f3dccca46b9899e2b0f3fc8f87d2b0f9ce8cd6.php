
<?php $__env->startSection('modal-title','Permisos del Usuario: '.$user->full_name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="user-permissions-form">
        <?php echo csrf_field(); ?>
        <div class="card-datatable">
            <table class="table table-bordered table-striped" id="table-generated">
                <thead>
                <tr>
                    <th>Slug</th>
                    <th>Permisos</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input main-control" name="<?php echo e($permission->slug); ?>" id="<?php echo e($permission->slug); ?>" value="<?php echo e($permission->slug); ?>">
                                    <label class="custom-control-label" for="<?php echo e($permission->slug); ?>"><?php echo e($permission->slug); ?></label>
                                </div>
                        <td>
                            <?php $__currentLoopData = explode(',',$permission->list); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="<?php echo e($permission->slug); ?> custom-control-input" name="perms[]" id="<?php echo e($permission->slug.".".$p); ?>" value="<?php echo e($permission->slug.".".$p); ?>" <?php if($user->hasAccess([$permission->slug.".".$p])): ?> checked <?php endif; ?>>
                                            <label class="custom-control-label" for="<?php echo e($permission->slug.".".$p); ?>"><?php echo e($p); ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </form>
    <script>
        $('.main-control').change(function() {
            var id = this.id;
            if($(this).is(":checked")) {

                $('.'+id).prop('checked',true);
            }else {
                $('.'+id).prop('checked',false);
            }
            //'unchecked' event code
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#user-permissions-form','/userPermissions/'.$user->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','60'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/user/permissions/index2.blade.php ENDPATH**/ ?>
