@extends('components.modals.form-modal')
@section('modal-title','Log de desconexiones')
@section('modal-content')
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Dispositivo</th>
                    <td>{{  $device->name }}</td>
                </tr>
                <tr>
                    <th>Punto de Control</th>
                    <td>{{  $device->check_point->name }}</td>
                </tr>
                <tr>
                    <th>Sub Zona</th>
                    <td>{{  $device->check_point->sub_zones()->first()->name }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            {!! makeTable(['Fecha de Inicio','Fecha de Término','Duración'],false,'table-log') !!}
        </div>
    </div>
    {!! getAjaxTable2('clientOfflineDevicesLog/'.$device->id,'table-log') !!}
@endsection
@section('no-submit')
    .
@endsection
