@extends('layouts.app')
@section('page-title','Dispositivos fuera de línea')
@section('page-icon','power-off')
@section('page-content')
    {!! makeDefaultView(['Zona','Sub zona','Punto de control','Fecha Inicio','Tiempo Transcurrido'],'clientOfflineDevicesList') !!}

@endsection
@section('page-extra-scripts')
    <script>
        setInterval(function(){tableReload()},60000);
    </script>
@endsection
