<?php $__env->startSection('mail-content'); ?>
    <tr>
        <td align="center" bgcolor="#ffffff" style="padding: 75px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
            <b>Hola, <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></b><br/>
            Hemos recibido una solicitud de cambio de contraseña, si no has sido tú ignora este email, de lo contrario haz click en el siguiente enlace.
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
            <table bgcolor="#0073AA" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                <tr>
                    <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                        <a href="https://erm.cmatik.app/reset/<?php echo e($user->email); ?>/<?php echo e($code); ?>" style="color: #ffffff; text-align: center; text-decoration: none;">Cambiar mi contraseña</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/emails/auth/forgot-password.blade.php ENDPATH**/ ?>