@extends('layouts.app')
@section('page-title','Listado de Cambios')
@section('page-icon','users')
@section('page-content')
    {!! makeDefaultView(['Usuario','Descripción','Tabla','Valores_antiguos','Nuevos Valores','Fecha'],'change-logs') !!}
@endsection
