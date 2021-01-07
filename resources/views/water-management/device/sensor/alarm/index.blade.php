@extends('layouts.app')
@section('page-title',$sensor->name.': Alarmas')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/sensors?device_id='.$sensor->device_id,'Sensores','fa-sitemap','btn-info','btn-md') !!}
@endsection
@section('page-content')
    {!! makeDefaultView(['Creada por','Rango Minimo','Rango Maximo','Activa','Enviar Email','total alarmas','Ultima Alarma','Acciones'],'sensor-alarms/'.$sensor->id) !!}
@endsection
