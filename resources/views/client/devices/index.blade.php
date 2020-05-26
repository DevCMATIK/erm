@extends('layouts.app')
@section('page-title','Dispositivos fuera de línea')
@section('page-icon','power-off')
@section('page-content')
    {!! makeDefaultView(['Zona','Sub_zona','Punto de control','Dipositivo','Fecha Inicio','Tiempo Transcurrido','log'],'clientOfflineDevices') !!}

@endsection
@section('page-extra-scripts')
    <script>
        setInterval(function(){tableReload()},60000);
    </script>
@endsection
