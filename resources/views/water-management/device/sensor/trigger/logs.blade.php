@extends('components.modals.form-modal')
@section('modal-title','Listado de registros del trigger')
@section('modal-content')
    <h5>Datos del disparador</h5>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Sub Zona</th>
                    <td>{{ $trigger->sensor->device->check_point->sub_zones->first()->name }}</td>
                </tr>
                <tr>
                    <th>Sensor Ejecutor</th>
                    <td>{{  $trigger->sensor->device->name.' - '.$trigger->sensor->name}}</td>
                </tr>
                <tr>
                    <th>Sensor Receptor</th>
                    <td>{{  $trigger->receptor->device->name.' - '.$trigger->receptor->name }}</td>
                </tr>
                @if($trigger->when_one !== null || $trigger->when_zero !== null)
                    <tr>
                        <th>Cuando sea 1</th>
                        <td>{{ $trigger->when_one }}</td>
                    </tr>
                    <tr>
                        <th>Cuando sea 0</th>
                        <td>{{ $trigger->when_zero }}</td>
                    </tr>
                @endif
                @if($trigger->range_min !== null || $trigger->range_max !== null)
                    <tr>
                        <th>Rango minimo</th>
                        <td>{{ $trigger->range_min }}</td>
                    </tr>
                    <tr>
                        <th>Rango Maximo</th>
                        <td>{{ $trigger->range_max }}</td>
                    </tr>
                    <tr>
                        <th>En rango max.</th>
                        <td>{{ $trigger->in_range }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Ejecutar Cada</th>
                    <td>{{ $trigger->minutes }} minuto(s)</td>
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
                    @forelse($trigger->logs as $log)
                        <tr>
                            <td>{{ $log->value_readed }}</td>
                            <td>{{ $log->command_executed }}</td>
                            <td>{{ $log->last_execution }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No ejecutado nunca.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {!! getTableScript('trigger-log-table') !!}
@endsection
@section('no-submit','.')
