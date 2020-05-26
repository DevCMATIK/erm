@extends('layouts.app')
@section('page-title','Usuarios')
@section('page-icon','users')
@section('page-content')
    {!! makeDefaultView(['Nombre','apellido','email','Telefono','Acciones'],'users') !!}
@endsection
