@extends('layouts.app')
@section('page-title','Reportes de Email')
@section('page-icon','envelope')
@section('page-content')
    {!! makeDefaultView(['Nombre','Email','Grupos','Creador','Frecuencia','Ejecutar en','activo','Ultima ejecucion','opciones'],'mail-reports') !!}
@endsection
