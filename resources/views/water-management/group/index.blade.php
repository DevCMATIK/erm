@extends('layouts.app')
@section('page-title','Grupos')
@section('page-icon','users')
@section('page-content')
	{!! makeDefaultView(['Nombre','Acciones'],'groups') !!}
@endsection
