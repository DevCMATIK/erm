
<?php $__env->startSection('modal-title','Listado de registros de alarma'); ?>
<?php $__env->startSection('modal-content'); ?>
    <h5>Datos de la alarma</h5>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Nombre Sensor</th>
                    <td><?php echo e($alarm->sensor->name.' Dispositivo: '.$alarm->sensor->device->name); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo e($alarm->sensor->full_address); ?></td>
                </tr>
                    <tr>
                        <th>Rango Minimo</th>
                        <td><?php echo e($alarm->range_min); ?></td>
                    </tr>
                    <tr>
                        <th>Rango Maximo</th>
                        <td><?php echo e($alarm->range_max); ?></td>
                    </tr>
                <tr>
                    <th>Activa</th>
                    <td><?php echo e(($alarm->is_active === 1)?'Si':'NO'); ?></td>
                </tr>
                <tr>
                    <th>Enviar Email</th>
                    <td><?php echo e(($alarm->send_email === 1)?'Si':'NO'); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Termino</th>
                    <th>Ultima Actualizacion</th>
                    <th>Primer Valor Leido</th>
                    <th>Ultimo Valor Leido</th>
                    <th>Tipo Alarma</th>
                    <th>Registros Contados</th>
                    <th>Acusada</th>
                    <th>Acusada por</th>
                    <th>Acusada el</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $alarm->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($log->start_date); ?></td>
                        <td><?php echo e($log->end_date); ?></td>
                        <td><?php echo e($log->last_update); ?></td>
                        <td><?php echo e($log->first_value_readed); ?></td>
                        <td><?php echo e($log->last_value_reded); ?></td>
                        <td><?php echo e($log->min_or_max); ?></td>
                        <td><?php echo e($log->entries_counted); ?></td>
                        <td><?php echo e(($log->accused === 1)? 'Si':'No'); ?></td>
                        <td><?php echo e($log->accuser->full_name ?? 'No Acusada'); ?></td>
                        <td><?php echo e($log->accused_at ?? 'No Acusada'); ?></td>
                        <td><?php echo e(($log->end_date != null )?'Resuelta':($log->accused === 1) ? 'Acusada' : 'Vigente'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10">No ejecutado nunca.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit','.'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/device/sensor/alarm/log.blade.php ENDPATH**/ ?>