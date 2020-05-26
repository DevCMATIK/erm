@extends('layouts.app')
@section('page-title','Tipos de Sensor')
@section('page-icon','database')
@section('page-content')
	{!! makeDefaultView(['Nombre','Intervalo','Acciones'],'sensor-types') !!}
@endsection
