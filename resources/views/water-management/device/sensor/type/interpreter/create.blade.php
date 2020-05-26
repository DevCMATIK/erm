@extends('components.modals.form-modal')
@section('modal-title','Crear Interpretador')
@section('modal-content')
    <form class="" role="form"  id="interpreter-form">
        @csrf
        <input type="hidden" name="type_id" value="{{ $type_id }}">

        <div class="form-group">
            <label class="form-label">Valor a comparar</label>
            <input type="text" class="form-control" id="value" name="value">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#interpreter-form','/interpreters', "tableReload(); closeModal();") !!}
@endsection
