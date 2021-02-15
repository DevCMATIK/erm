@extends('layouts.app-navbar')
@section('page-title')
    Puntos de Control que reportan a DGA
    @if (Sentinel::getUser()->hasAccess('dga.export'))
        {!! makeLink(route('check-point.reports-export'),'Exportar Todo','fa-file-excel','btn-success float-right','btn-md') !!}
    @endif

@endsection
@section('page-icon','database')
@section('page-content')
    <label class="btn btn-panel hover-effect-dot js-panel-collapse waves-effect waves-themed"></label>
    {!! makeDefaultView(['Punto de Control','Código de Obra','Frecuencia','Zona','Cantidad de reportes','Status','Acciones'],'check-point/dga-reports') !!}
@endsection
