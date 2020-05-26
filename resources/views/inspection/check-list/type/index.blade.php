@extends('layouts.app')
@section('page-title','Tipos de Check List')
@section('page-icon','check-square')
@section('page-content')
	{!! makeDefaultView(['Nombre','Acciones'],'check-list-types') !!}
@endsection
