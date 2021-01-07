@extends('layouts.app')
@section('page-title',$sensor->name.': Triggers')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/sensors?device_id='.$sensor->device_id,'Sensores','fa-sitemap','btn-info','btn-md') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Creador','Sensor Receptor','Cuando sea 1','Cuando sea 0','Rango_minimo','Rango_maximo','en rango max.','Ejecutar Cada','Estado','ultima vez ejecutado','Acciones'],'sensor-triggers/'.$sensor_id) !!}
@endsection
