
<h5>
    <i class="fas fa-users"></i>
    <?php echo e($group->name); ?>

</h5>
<hr>
<form id="user-group-form">
    <?php echo csrf_field(); ?>
    <select name="users[]" id="usersGroupList" class="form-control" multiple>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($group->users->contains($user)): ?>
                <option value="<?php echo e($user->id); ?>" selected><?php echo e($user->full_name); ?></option>
            <?php else: ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->full_name); ?></option>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-info btn-block">Guardar</button>
    </div>
</form>
<script>
    $('#usersGroupList').bootstrapDualListbox({
        nonSelectedListLabel: 'Listado de usuarios',
        selectedListLabel: 'Usuarios en el grupo',
        preserveSelectionOnMove: 'moved'
    });


</script>
<?php echo makeValidation('#user-group-form','/handleUsersFromGroup/'.$group->id,'getUsersFromGroup('.$group->id.')'); ?>



<?php /**PATH /shared/httpd/water-management/resources/views/manage/group/users-list.blade.php ENDPATH**/ ?>