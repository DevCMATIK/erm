@extends('layouts.app-navbar')
@section('page-title',$checkPoint->name.': Dispositivos')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/check-points?type='.$checkPoint->type->slug,'Puntos de Control','fa-sitemap','btn-info','btn-md') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Id interno','Nombre','tipo','Acciones'],'devices/'.$check_point_id,$navBar) !!}
@endsection
