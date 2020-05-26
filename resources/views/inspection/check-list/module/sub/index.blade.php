@extends('layouts.app')
@section('page-title','Sub Modulos Check List : '.$module->name)
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/check-list-modules?check_list_id='.$module->check_list_id,'Modulos','fa-check-square','btn-info','btn-sm') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','Columnas','Acciones'],'check-list-sub-modules/'.$module->id) !!}
@endsection
