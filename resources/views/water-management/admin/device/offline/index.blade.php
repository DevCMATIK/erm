@extends('layouts.app')
@section('page-title','Dispositivos fuera de línea')
@section('page-icon','power-off')
@section('page-content')
    {!! makeDefaultView(['Zona','Sub_zona','Punto de control','Dipositivo','Id_Interno','Total','Fecha Inicio','Tiempo Transcurrido','log'],'offline-devices') !!}

@endsection
@section('page-extra-scripts')
    <script>
        setInterval(function(){tableReload()},60000);
    </script>
@endsection
