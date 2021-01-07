@extends('layouts.app')
@section('page-title','Comandos Ejecutados')
@section('page-icon','database')
@section('page-buttons')

    {!! makeLink('/export-commands-executed','Exportar','fa-file-excel','btn-success','btn-md') !!}

@endsection
@section('page-content')
    {!! makeDefaultView(['Zona','sub zona','Punto de Control','Variable','Orden Ejecutada','Usuario','Fecha'],'commands-executed') !!}
@endsection
