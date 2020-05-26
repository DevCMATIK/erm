@extends('components.modals.form-modal')
@section('modal-title','Modificar tipo de check list')
@section('modal-content')
    <form class="" role="form"  id="type-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $type->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/check-list-types/'.$type->id, "tableReload(); closeModal();") !!}
@endsection
