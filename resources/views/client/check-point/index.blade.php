@extends('layouts.app-navbar')
@section('page-title','Puntos de Control')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/check-point-types','Tipos','fa-sitemap','btn-info','btn-sm') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Tipo','Nombre','Zona(s)','Dispositivos','Acciones'],'check-points/'.$type,$navBar) !!}
@endsection
