<table class="table table-stripped">
    <thead>
    <tr>
        <th>Id Logs</th>
        <th>Usuario</th>
        <th>Tipo de Evento</th>
        <th>URL</th>
        <th>Direccion IP</th>
        <th>Fecha Creacion</th>
        <th>Fecha Actualizacion</th>

    </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($log->id); ?></td>
            <td><?php echo e($log->user_id); ?></td>
            <td><?php echo e($log->event); ?></td>
            <td><?php echo e($log->url); ?></td>
            <td><?php echo e($log->ip_address); ?></td>
            <td><?php echo e($log->created_at); ?></td>
            <td><?php echo e($log->updated_at); ?></td>



        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="11">No hay registros.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php /**PATH /shared/httpd/erm/resources/views/audit/log.blade.php ENDPATH**/ ?>