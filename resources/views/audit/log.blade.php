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
    @forelse($logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_id }}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->url }}</td>
            <td>{{ $log->ip_address }}</td>
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->updated_at }}</td>



        </tr>
    @empty
        <tr>
            <td colspan="11">No hay registros.</td>
        </tr>
    @endforelse
    </tbody>
</table>

