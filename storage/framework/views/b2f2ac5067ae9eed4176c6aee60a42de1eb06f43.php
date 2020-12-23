<table class="table table-stripped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Tipo de Usuario</th>
        <th>Id Usuario</th>
        <th>Tipo de Evento</th>
        <th>Tipo Auditable</th>
        <th>Id Auditable</th>
        <th>Valor Anterior</th>
        <th>Nuevo Valor</th>
        <th>URL</th>
        <th>Direccion IP</th>
        <th>User Agent</th>
        <th>Tags</th>
        <th>Fecha Creacion</th>
        <th>Fecha Actualizacion</th>
    </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $all_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($log->id); ?></td>
            <td><?php echo e($log->user_type); ?></td>
            <td><?php echo e($log->user_id); ?></td>
            <td><?php echo e($log->event); ?></td>
            <td><?php echo e($log->auditable_type); ?></td>
            <td><?php echo e($log->auditable_id); ?></td>
            <td><?php echo e($log->ip_address); ?></td>
            <td><?php echo e($log->user_agent); ?></td>
            <td><?php echo e($log->tags); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($log->create_at)->diff(\Carbon\Carbon::parse($log->create_at) ?? \Carbon\Carbon::now())->format('%H:%I:%S')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($log->update_at)->diff(\Carbon\Carbon::parse($log->update_at) ?? \Carbon\Carbon::now())->format('%H:%I:%S')); ?></td>


            <td><?php echo e($log->update_at); ?></td>

            <td><?php echo e($log->start_date); ?></td>

        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="11">No hay registros.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/audit/log.blade.php ENDPATH**/ ?>