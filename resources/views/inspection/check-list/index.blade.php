@extends('layouts.app')
@section('page-title','Check Lists')
@section('page-icon','check-square')
@section('page-content')
	{!! makeDefaultView(['Nombre','Punto de Control','Acciones'],'check-lists') !!}
@endsection
