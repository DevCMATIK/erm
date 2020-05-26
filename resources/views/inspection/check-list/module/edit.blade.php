@extends('components.modals.form-modal')
@section('modal-title','Modificar Modulo de check list')
@section('modal-content')
    <form class="" role="form"  id="check-list-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $module->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-list-form','/check-list-modules/'.$module->id, "tableReload(); closeModal();") !!}
@endsection
