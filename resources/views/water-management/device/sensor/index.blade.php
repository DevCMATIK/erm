@extends('layouts.app-navbar')
@section('page-title',$device->name.': Sensores')
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/devices?check_point_id='.$device->check_point_id,'Dispositivos','fa-sitemap','btn-info','btn-md') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Nombre','Tipo','Tipo de registro','Direccion','Acciones'],'sensors/'.$device_id,$navBar) !!}
@endsection
