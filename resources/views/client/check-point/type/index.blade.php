@extends('layouts.app-navbar')
@section('page-title','Tipos de puntos de control')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Nombre','Puntos de Control','Acciones'],'check-point-types',$navBar) !!}
@endsection
