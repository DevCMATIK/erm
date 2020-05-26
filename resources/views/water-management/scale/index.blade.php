@extends('layouts.app')
@section('page-title','Escalas')
@section('page-icon','database')
@section('page-content')
	{!! makeDefaultView(['Nombre','Rango min.','Rango max.','Decimales','Acciones'],'scales') !!}
@endsection
