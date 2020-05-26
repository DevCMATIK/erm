@extends('layouts.app')
@section('page-title','Roles')
@section('page-icon','key')
@section('page-content')
	{!! makeDefaultView(['Slug','Nombre','Acciones'],'roles') !!}
@endsection
