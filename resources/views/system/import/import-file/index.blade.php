@extends('layouts.app')
@section('page-title','Import: ' . $import->name)
@section('page-icon','database')
@section('page-buttons')
    {!! makeLink('/getImports','Volver','fa-arrow-left','btn-info') !!}
    {!! makeRemoteLink('/importFile/'.$import->slug.'/upload','Subir Archivo','fa-upload') !!}
@endsection
@section('page-content')
	{!! makeDefaultView(['Usuario','Archivo','extensión','Status','Subido el','Acciones'],'import-files/'.$import->slug) !!}
@endsection

