@extends('layouts.main.app')
@section('page-title','Sequencias de importacion')
@section('page-icon','list-ol')
@section('content')
    {!! makeDefaultView(['nombre','Modulos a importar','Acciones'],'queueImports') !!}
@endsection

