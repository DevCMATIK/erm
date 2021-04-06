
<?php $__env->startSection('modal-title','Listado de registros del trigger'); ?>
<?php $__env->startSection('modal-content'); ?>
    <h5>Datos del disparador</h5>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Sub Zona</th>
                    <td><?php echo e($trigger->sensor->device->check_point->sub_zones->first()->name); ?></td>
                </tr>
                <tr>
                    <th>Sensor Ejecutor</th>
                    <td><?php echo e($trigger->sensor->device->name.' - '.$trigger->sensor->name); ?></td>
                </tr>
                <tr>
                    <th>Sensor Receptor</th>
                    <td><?php echo e($trigger->receptor->device->name.' - '.$trigger->receptor->name); ?></td>
                </tr>
                <?php if($trigger->when_one !== null || $trigger->when_zero !== null): ?>
                    <tr>
                        <th>Cuando sea 1</th>
                        <td><?php echo e($trigger->when_one); ?></td>
                    </tr>
                    <tr>
                        <th>Cuando sea 0</th>
                        <td><?php echo e($trigger->when_zero); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($trigger->range_min !== null || $trigger->range_max !== null): ?>
                    <tr>
                        <th>Rango minimo</th>
                        <td><?php echo e($trigger->range_min); ?></td>
                    </tr>
                    <tr>
                        <th>Rango Maximo</th>
                        <td><?php echo e($trigger->range_max); ?></td>
                    </tr>
                    <tr>
                        <th>En rango max.</th>
                        <td><?php echo e($trigger->in_range); ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th>Ejecutar Cada</th>
                    <td><?php echo e($trigger->minutes); ?> minuto(s)</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-bordered" id="trigger-log-table">
                <thead>
                    <tr>
                        <th>Valor Leido</th>
                        <th>Comando Ejecutado</th>
                        <th>Fecha ejecucion</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $trigger->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($log->value_readed); ?></td>
                            <td><?php echo e($log->command_executed); ?></td>
                            <td><?php echo e($log->last_execution); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3">No ejecutado nunca.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo getTableScript('trigger-log-table'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit','.'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/trigger/logs.blade.php ENDPATH**/ ?>