@extends('layouts.app-navbar')
@section('page-title','Puntos de Control que reportan a DGA')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Punto de Control','Tipo','Zona','Cantidad de reportes','Acciones'],'check-point/dga-reports') !!}
@endsection
