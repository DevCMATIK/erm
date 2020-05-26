@extends('layouts.modal.layout')
@section('modal-icon','fa-exclamation-circle')
@section('modal-title','Log de errores')
@section('modal-content')
	{!! includeDT() !!}
	<a href="/importFile/cleanErrors/{{ $importFile->id }}" class="btn btn-primary"> Limpiar Log de Errores</a>
	<div class="table-responsive">

		{!! makeTable(['row_num','feedback','data'],$importFile->error_messages->only(['row_num','feedback','data'])->toArray(),'log-error-table') !!}
	</div>
	{!! getSimpleTableScript('log-error-table') !!}
@endsection
@section('modal-validation')
@endsection
@section('modal-width','50')
