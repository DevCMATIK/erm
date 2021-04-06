
<?php $__env->startSection('mail-header'); ?>
   Archivos Generados Correctamente!
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mail-content'); ?>
    <p>
        <span style="font-size: 18px;">﻿</span>
        <span style="font-size: 18px;">﻿</span>
        <b>
            <span style="font-size: 12px;">
                <span style="font-size: 18px;"><?php echo e($user->full_name); ?></span>,
            </span>
        </b>
    </p>
    <p>Se han generado los archivos solicitados en <?php echo e($reminder->creation_date); ?></p>
    <p>Haga click en el siguiente enlace para ir a la página de descarga:</p>
    <p>
        <a href="https://erm.cmatik.app/descargar-archivos/<?php echo e($reminder->id); ?>" target="_blank">Click Aqui</a><br>
    </p>
    <p><br></p>
    <p>Saludos Cordiales</p>
    <p>ERM® CMATIK</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/emails/files-created.blade.php ENDPATH**/ ?>