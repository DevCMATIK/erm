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
    @forelse($all_logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_type }}</td>
            <td>{{ $log->user_id }}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->auditable_type }}</td>
            <td>{{ $log->auditable_id }}</td>
            <td>{{ $log->ip_address }}</td>
            <td>{{ $log->user_agent }}</td>
            <td>{{ $log->tags }}</td>
            <td>{{ \Carbon\Carbon::parse($log->create_at)->diff(\Carbon\Carbon::parse($log->create_at) ?? \Carbon\Carbon::now())->format('%H:%I:%S') }}</td>
            <td>{{ \Carbon\Carbon::parse($log->update_at)->diff(\Carbon\Carbon::parse($log->update_at) ?? \Carbon\Carbon::now())->format('%H:%I:%S') }}</td>


            <td>{{ $log->update_at }}</td>

            <td>{{ $log->start_date }}</td>

        </tr>
    @empty
        <tr>
            <td colspan="11">No hay registros.</td>
        </tr>
    @endforelse
    </tbody>
</table>

