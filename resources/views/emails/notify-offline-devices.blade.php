@extends('emails.base')

@section('mail-content')
    <p style="text-align: center;">
        <span style="font-size: 18px;">
            Hola, Se adjunta listado de dispositivos que se encuentran desconectados hace más de 15 minutos.
        </span>
    </p><br><br>
    <table width="100%"  cellspacing="0" class="table table-striped"  style="margin: auto; text-align: center; border: none;" >
        <thead>
        <tr>
            <th width="25%">ZONA</th>
            <th width="25%">SUB ZONA</th>
            <th width="25%">DISPOSITIVO</th>
            <th width="25%">HORA DESCONEXIÓN</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td width="25%">{{ $log->device->check_point->sub_zones->first()->zone->name }}</td>
                <td width="25%">{{ $log->device->check_point->sub_zones->first()->name }}</td>
                <td width="25%">{{ $log->device->name }}</td>
                <td width="25%">{{ $log->start_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <br>
@endsection
