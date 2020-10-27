<table class="table table-stripped">
    <thead>
        <tr>
            <th>Zona</th>
            <th>Sub Zona</th>
            <th>Punto de Control</th>
            <th>Variable</th>
            <th>Fecha activación</th>
            <th>Valor</th>
            <th>Último Valor</th>
            <th>Tipo</th>
            <th>Acusada</th>
            <th>Usuario</th>
            <th>Recordarme</th>
            <?php if(Sentinel::getUser()->hasAccess(['alarms.uncheck'])): ?>
                <th>Desacusar</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $alarm_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($log->zone); ?></td>
            <td><a href="/dashboard/<?php echo e($log->sub_zone_id); ?>" class="btn-link"><?php echo e($log->sub_zone); ?></a></td>
            <td><?php echo e($log->device); ?></td>
            <td><?php echo e($log->sensor); ?></td>
            <td><?php echo e($log->start_date); ?></td>
            <td><?php echo e(number_format($log->first_value_readed,2)); ?></td>
            <td><?php echo e(number_format($log->last_value,2)); ?></td>
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
            <td><?php echo e(($log->accused === 1)? 'Si':'No'); ?></td>
            <td><?php echo e(($log->accused === 1)? $log->first_name.' '.$log->last_name:'No'); ?></td>
            <td> <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input reminder_check" value="reminder_<?php echo e($log->log_id); ?>_<?php echo e(Sentinel::getUSer()->id); ?>" name="reminder" id="reminder_<?php echo e($log->log_id); ?>_<?php echo e(Sentinel::getUser()->id); ?>" <?php if(\App\Domain\System\User\User::find(Sentinel::getUser()->id)->alarm_reminders()->where('alarm_notification_id',$log->log_id)->first()): ?> checked <?php endif; ?>>
                    <span class="custom-control-label"></span>
                </label>
            </td>
            <?php if(Sentinel::getUser()->hasAccess(['alarms.uncheck'])): ?>
                <td><?php echo makeLink('/alarm/accused/'.$log->log_id,' ','fa-times','btn-warning','btn-xs'); ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="6">No hay Alarmas Activas.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<script>
    $(document).ready(function()
    {
        $('.reminder_check').click(function(e){
            let element = $(this);
            let remindMe;
            if(element.prop("checked") === true){
                remindMe = 1;
            }
            else if(element.prop("checked") === false){
                remindMe = 0;
            }


                $.get('/remindMeAlarm', {
                        element : element.attr('id'),
                        remindMe : remindMe
                    } ,function() {
                        if(remindMe === 1) {
                            toastr.info('Recordatorio creado');
                        } else {
                            toastr.info('Recordatorio removido');
                        }
                    }
                )

        });
    });
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/alarm/active-table.blade.php ENDPATH**/ ?>