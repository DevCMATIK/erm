@extends('components.modals.form-modal')
@section('modal-title','Crear Unidad')
@section('modal-content')
    <form class="" role="form"  id="unit-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#unit-form','/units', "tableReload(); closeModal();") !!}
@endsection
