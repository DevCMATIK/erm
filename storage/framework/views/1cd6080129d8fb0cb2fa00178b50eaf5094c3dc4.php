<table class="table table-stripped">
    <thead>
    <tr>
        <th>Zona</th>
        <th>Sub Zona</th>
        <th>Punto de Control</th>
        <th>Variable</th>
        <th>Tipo</th>
        <th>Fecha activación</th>
        <th>Fecha término</th>
        <th>Duración</th>
        <th>Valor</th>
        <th>Último Valor</th>
        <th>Acusada</th>
        <th>Acusada por</th>
        <th>Fecha Acuse</th>
    </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $alarm_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($log->zone); ?></td>
            <td><?php echo e($log->sub_zone); ?></td>
            <td><?php echo e($log->device); ?></td>
            <td><?php echo e($log->sensor); ?></td>
            <td>
                <?php switch($log->type):
                    case (1): ?>
                    Bajo
                    <?php break; ?>
                    <?php case (2): ?>
                    Alto
                    <?php break; ?>
                    <?php case (3): ?>
                    Digital
                    <?php break; ?>
                <?php endswitch; ?>
            </td>
            <td><?php echo e($log->start_date); ?></td>
            <td><?php echo e($log->end_date ?? 'Activa'); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($log->start_date)->diff(\Carbon\Carbon::parse($log->end_date) ?? \Carbon\Carbon::now())->format('%H:%I:%S')); ?></td>
            <td><?php echo e(number_format($log->first_value_readed,2)); ?></td>
            <td><?php echo e(number_format($log->last_value,2)); ?></td>
            <td><?php echo e(($log->accused === 1)? 'Si':'No'); ?></td>
            <td><?php echo e(($log->accused === 1)? $log->first_name.' '.$log->last_name:'N/A'); ?></td>
            <td><?php echo e(($log->accused_at)?? 'No Acusada'); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="11">No hay registros de alarmas.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/alarm/last-log.blade.php ENDPATH**/ ?>
