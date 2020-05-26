@extends('components.modals.form-modal')
@section('modal-title','Listado de registros de alarma')
@section('modal-content')
    <h5>Datos de la alarma</h5>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Nombre Sensor</th>
                    <td>{{  $alarm->sensor->name.' Dispositivo: '.$alarm->sensor->device->name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{  $alarm->sensor->full_address }}</td>
                </tr>
                    <tr>
                        <th>Rango Minimo</th>
                        <td>{{ $alarm->range_min }}</td>
                    </tr>
                    <tr>
                        <th>Rango Maximo</th>
                        <td>{{ $alarm->range_max }}</td>
                    </tr>
                <tr>
                    <th>Activa</th>
                    <td>{{ ($alarm->is_active === 1)?'Si':'NO' }}</td>
                </tr>
                <tr>
                    <th>Enviar Email</th>
                    <td>{{ ($alarm->send_email === 1)?'Si':'NO' }}</td>
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
                @forelse($alarm->logs as $log)
                    <tr>
                        <td>{{ $log->start_date }}</td>
                        <td>{{ $log->end_date }}</td>
                        <td>{{ $log->last_update }}</td>
                        <td>{{ $log->first_value_readed }}</td>
                        <td>{{ $log->last_value_reded }}</td>
                        <td>{{ $log->min_or_max }}</td>
                        <td>{{ $log->entries_counted }}</td>
                        <td>{{ ($log->accused === 1)? 'Si':'No' }}</td>
                        <td>{{ $log->accuser->full_name ?? 'No Acusada' }}</td>
                        <td>{{ $log->accused_at ?? 'No Acusada' }}</td>
                        <td>{{ ($log->end_date != null )?'Resuelta':($log->accused === 1) ? 'Acusada' : 'Vigente' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No ejecutado nunca.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('no-submit','.')
