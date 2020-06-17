@extends('layouts.app')
@section('page-title',$sensor->name.': Cronómetros')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['Valor igual que','Usos','Acciones'],'sensor-chronometers/'.$sensor->id) !!}
@endsection
