@extends('layouts.app')
@section('page-title',$type->name.': Interpretadores')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/sensor-types','Tipos de Sensor','fa-sitemap','btn-info','btn-sm') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Valor','Nombre','Descripción','Acciones'],'interpreters/'.$type_id) !!}
@endsection
