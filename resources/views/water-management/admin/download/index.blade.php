@extends('layouts.app-navbar')
@section('page-title','Listado de Descargas por correo')
@section('page-icon','list')

@section('page-content')
    {!! makeDefaultView(['Fecha','Usuario','Sensores','Fecha inicio','fecha termino'],'userDownloads') !!}
@endsection
