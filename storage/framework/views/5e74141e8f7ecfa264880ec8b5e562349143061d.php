

<?php $__env->startSection('mail-content'); ?>
    <p style="text-align: center;">
        <span style="font-size: 18px;">
            Hola, Se adjunta listado de dispositivos que se encuentran desconectados hace más de 15 minutos.
        </span>
    </p><br><br>
    <table width="100%"  cellspacing="0" class="table table-striped"  style="margin: auto; text-align: center; border: none;" >
        <thead>
        <tr>
            <th width="25%">ZONA</th>
            <th width="25%">SUB ZONA</th>
            <th width="25%">DISPOSITIVO</th>
            <th width="25%">HORA DESCONEXIÓN</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td width="25%"><?php echo e($log->device->check_point->sub_zones->first()->zone->name); ?></td>
                <td width="25%"><?php echo e($log->device->check_point->sub_zones->first()->name); ?></td>
                <td width="25%"><?php echo e($log->device->name); ?></td>
                <td width="25%"><?php echo e($log->start_date); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <br>
    <br>
    <br>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/emails/notify-offline-devices.blade.php ENDPATH**/ ?>