@extends('components.modals.form-modal')
@section('modal-title','Crear tipo punto de control')
@section('modal-content')
    <form class="" role="form"  id="check-point-type-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-point-type-form','/check-point-types', "tableReload(); closeModal();") !!}
@endsection
