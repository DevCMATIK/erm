@extends('layouts.app')
@section('page-title','Zonas')
@section('page-icon','database')
@section('page-buttons')

    {!! makeRemoteLink('/zoneSerialization','Serializar','fa-list-ol','btn-info','btn-md') !!}

@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','nombre en menú','Sub Zonas','Acciones'],'zones') !!}
@endsection
