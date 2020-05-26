@extends('layouts.app')
@section('page-title','Controles Check List : '.$subModule->name)
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/check-list-sub-modules?module='.$subModule->module_id,'Sub Modulos','fa-check-square','btn-info','btn-sm') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','Tipo','Valores','Metrica','Requerido','Acciones'],'check-list-controls/'.$subModule->id) !!}
@endsection
