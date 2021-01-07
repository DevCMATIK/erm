@extends('layouts.app')
@section('page-title','Menu principal')
@section('page-icon','bars')
@if(Sentinel::getUser()->hasAccess('menus.serialize'))
@section('page-buttons')

    {!! makeRemoteLink('/menuSerialization','Serializar','fa-list-ol','btn-info','btn-md') !!}

@endsection
@endif
@section('page-content')
    {!! makeDefaultView(['icono','nombre','ruta','posicion','parent','Acciones'],'menus') !!}
@endsection

