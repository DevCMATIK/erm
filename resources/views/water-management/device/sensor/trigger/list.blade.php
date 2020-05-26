@extends('layouts.app')
@section('page-title','Triggers')
@section('page-icon','database')

@section('page-content')
    {!! makeDefaultView(['Creador','sub zona','Sensor Receptor','Sensor Ejecutor','Cuando sea 1','Cuando sea 0','Rango_minimo','Rango_maximo','en rango max','Ejecutar Cada','ultima vez ejecutado','Acciones'],'triggers-list') !!}
@endsection
