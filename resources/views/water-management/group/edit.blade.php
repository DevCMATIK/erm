@extends('components.modals.form-modal')
@section('modal-title','Modificar Grupo')
@section('modal-content')
    <form class="" role="form"  id="group-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $group->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#group-form','/groups/'.$group->id, "tableReload(); closeModal();") !!}
@endsection
