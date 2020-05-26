@extends('layouts.app')
@section('page-title','Imports')
@section('page-icon','database')
@section('page-content')
    {!! makeDefaultView(['nombre','slug','descripción','role_necesario','Acciones'],'imports') !!}
@endsection

