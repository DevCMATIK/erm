@extends('components.modals.form-modal')
@section('modal-title','Crear tipo de check list')
@section('modal-content')
    <form class="" role="form"  id="type-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/check-list-types', "tableReload(); closeModal();") !!}
@endsection
