@extends('layouts.app')
@section('page-title','Areas de produccion')
@section('page-icon','database')
@section('page-content')
	{!! makeDefaultView(['Nombre','Acciones'],'production-areas') !!}
@endsection
