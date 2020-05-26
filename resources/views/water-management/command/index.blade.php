@extends('layouts.app-navbar')
@section('page-title','Log de Commandos ejecutados por usuarios')
@section('page-icon','database')

@section('page-content')
    {!! makeDefaultView(['Usuario','Email','Dispositivo','Sensor','Address','grd_id','Orden ejecutada','Fecha','IP'],'command-log') !!}
@endsection
