@extends('components.modals.form-modal')
@section('modal-title','Modificar Interpretadors')
@section('modal-content')
    <form class="" role="form"  id="interpreter-form">
        @csrf
        @method('put')

        <div class="form-group">
            <label class="form-label">Valor a comparar</label>
            <input type="text" class="form-control" id="value" name="value" value="{{ $interpreter->value }}">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $interpreter->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $interpreter->description }}">
        </div>


    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#interpreter-form','/interpreters/'.$interpreter->id, "tableReload(); closeModal();") !!}
@endsection
