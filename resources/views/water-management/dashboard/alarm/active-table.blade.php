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
            @if(Sentinel::getUser()->hasAccess(['alarms.uncheck']))
                <th>Desacusar</th>
            @endif
        </tr>
    </thead>
    <tbody>
    @forelse($alarm_logs as $log)
        <tr>
            <td>{{ $log->zone }}</td>
            <td><a href="/dashboard/{{ $log->sub_zone_id }}" class="btn-link">{{ $log->sub_zone }}</a></td>
            <td>{{ $log->device }}</td>
            <td>{{ $log->sensor }}</td>
            <td>{{ $log->start_date }}</td>
            <td>{{ number_format($log->first_value_readed,2) }}</td>
            <td>{{ number_format($log->last_value,2) }}</td>
            <td>
                @switch($log->type)
                    @case(1)
                    Bajo
                    @break
                    @case(2)
                    Alto
                    @break
                    @case(3)
                    Digital
                    @break
                @endswitch
            </td>
            <td>{{ ($log->accused === 1)? 'Si':'No' }}</td>
            <td>{{ ($log->accused === 1)? $log->first_name.' '.$log->last_name:'No' }}</td>
            <td> <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input reminder_check" value="reminder_{{ $log->log_id }}_{{ Sentinel::getUSer()->id }}" name="reminder" id="reminder_{{ $log->log_id }}_{{ Sentinel::getUser()->id }}" @if(\App\Domain\System\User\User::find(Sentinel::getUser()->id)->alarm_reminders()->where('alarm_notification_id',$log->log_id)->first()) checked @endif>
                    <span class="custom-control-label"></span>
                </label>
            </td>
            @if(Sentinel::getUser()->hasAccess(['alarms.uncheck']))
                <td>{!! makeLink('/alarm/accused/'.$log->log_id,' ','fa-times','btn-warning','btn-xs') !!}</td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="6">No hay Alarmas Activas.</td>
        </tr>
    @endforelse
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
