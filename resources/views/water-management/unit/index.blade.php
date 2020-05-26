@extends('layouts.app')
@section('page-title','Unidades')
@section('page-icon','database')
@section('page-content')
	{!! makeDefaultView(['Nombre','Acciones'],'units') !!}
@endsection
