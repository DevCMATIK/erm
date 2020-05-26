@extends('layouts.app')
@section('page-title','Modulos Check List : '.$checkList->name)
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/check-lists','Check Lists','fa-check-square','btn-info','btn-sm') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','Posicion','Acciones'],'check-list-modules/'.$checkList->id) !!}
@endsection
