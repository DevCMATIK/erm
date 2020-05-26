@extends('layouts.app')
@section('page-title','Log de emails')
@section('page-icon','envelope')
@section('page-content')
    {!! makeDefaultView(['Mail','identificador','fecha de envio','receptores'],'mail-logs') !!}
@endsection
