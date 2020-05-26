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
    @forelse($alarm_logs as $log)
        <tr>
            <td>{{ $log->zone }}</td>
            <td>{{ $log->sub_zone }}</td>
            <td>{{ $log->device }}</td>
            <td>{{ $log->sensor }}</td>
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
            <td>{{ $log->start_date }}</td>
            <td>{{ $log->end_date ?? 'Activa' }}</td>
            <td>{{ \Carbon\Carbon::parse($log->start_date)->diff(\Carbon\Carbon::parse($log->end_date) ?? \Carbon\Carbon::now())->format('%H:%I:%S') }}</td>
            <td>{{ number_format($log->first_value_readed,2) }}</td>
            <td>{{ number_format($log->last_value,2) }}</td>
           
            <td>{{ ($log->accused === 1)? 'Si':'No' }}</td>
            <td>{{ ($log->accused === 1)? $log->first_name.' '.$log->last_name:'N/A' }}</td>
            <td>{{ ($log->accused_at)?? 'No Acusada' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="11">No hay registros de alarmas.</td>
        </tr>
    @endforelse
    </tbody>
</table>

