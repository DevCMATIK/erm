@extends('layouts.app')
@section('page-title','Tipos de Historico')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Id Interno','Nombre','Acciones'],'historical-types') !!}
@endsection
