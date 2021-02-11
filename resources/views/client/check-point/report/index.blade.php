@extends('layouts.app-navbar')
@section('page-title')
    Puntos de Control que reportan a DGA
    {!! makeLink(route('check-point.reports-export'),'Exportar Todo','fa-file-excel','btn-success float-right','btn-md') !!}
@endsection
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Punto de Control','Código de Obra','Frecuencia','Zona','Cantidad de reportes','Acciones'],'check-point/dga-reports') !!}
@endsection
