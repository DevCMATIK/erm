@extends('components.modals.form-modal')
@section('modal-title','Crear Tipo de Registro')
@section('modal-content')
    <form class="" role="form"  id="register-type-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="internal_id">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#register-type-form','/register-types', "tableReload(); closeModal();") !!}
@endsection
