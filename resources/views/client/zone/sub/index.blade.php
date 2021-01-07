@extends('layouts.app')
@section('page-title','Sub Zonas')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/zones','Zonas','fa-sitemap','btn-info','btn-md') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','Zona','Acciones'],'sub-zones/'.$zone) !!}
@endsection

