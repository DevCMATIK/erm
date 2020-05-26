@extends('layouts.app')
@section('page-title','Alarmas creadas')
@section('page-icon','exclamation-triangle')

@section('page-content')
    {!! makeDefaultView(['Creador','sub_zona','dispositivo','Sensor','Rango Minimo','Rango Maximo','Activa','Enviar Mail','Alarma Activa','Log','Acusar'],'alarms-list') !!}
@endsection
