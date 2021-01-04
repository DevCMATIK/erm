<div class="card-body pb-2">
    <form class="" role="form"  id="password-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control"  name="old_password" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control"  name="password">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Repita Contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
        </div>
    </form>
    <?php echo makeValidation('#password-form','/changePassword', "$('#password-form').trigger('reset')"); ?>

</div>
<?php /**PATH /shared/httpd/erm/resources/views/user/settings/change-password.blade.php ENDPATH**/ ?>