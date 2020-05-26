@extends('layouts.app')
@section('page-title','Tipos de Dispositivo')
@section('page-icon','database')
@section('page-content')
	{!! makeDefaultView(['Nombre','Modelo','marca','Acciones'],'device-types') !!}
@endsection
