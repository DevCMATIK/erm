@extends('components.modals.form-modal')
@section('modal-title','Modificar Tipo de registro')
@section('modal-content')
    <form class="" role="form"  id="register-type-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="internal_id" value="{{ $register->internal_id }}">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $register->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#register-type-form','/register-types/'.$register->id, "tableReload(); closeModal();") !!}
@endsection
