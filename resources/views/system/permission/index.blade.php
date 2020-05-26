@extends('layouts.app')
@section('page-title','Permisos')
@section('page-icon','th-list')
@section('page-content')
    {!! makeDefaultView(['Slug','Nombre','Acciones'],'permissions') !!}
@endsection
