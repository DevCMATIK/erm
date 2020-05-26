@extends('layouts.app')
@section('page-title','Tipos de registro')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Id Interno','Nombre','Acciones'],'register-types') !!}
@endsection
