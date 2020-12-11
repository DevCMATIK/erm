
<div class="card-body media align-items-center">
    <img src="<?php if($avatar): ?><?php echo e(Storage::url($avatar->getFullPath())); ?><?php else: ?> <?php echo e(asset('images/user.png')); ?> <?php endif; ?>" alt="" class="d-block ui-w-80" width="200px" height="200px">
    <div class="media-body ml-4">
        <?php echo makeRemoteLink('/file/upload/users/'.Sentinel::getUser()->id,'Subir Imágen','fa-camera-retro','btn-outline-primary'); ?>

        <?php if($avatar): ?>
            <?php echo makeDeleteButton('Realmente desea eliminar su Imagen?',$user->id,'grantPermission','files/users'); ?>

        <?php endif; ?>
    </div>
</div>
<hr class="border-light m-0">

<div class="card-body">
    <form class="" role="form"  id="user-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="first_name" value="<?php echo e($user->first_name); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control"  name="last_name" value="<?php echo e($user->last_name); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="<?php echo e($user->email); ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php echo makeValidation('#user-form','/accountGeneral', ""); ?>

    <?php echo makeValidation('#avatar-form','/uploadAvatar', "location.reload();"); ?>

</div>
<?php /**PATH /shared/httpd/erm/resources/views/user/settings/account-general.blade.php ENDPATH**/ ?>