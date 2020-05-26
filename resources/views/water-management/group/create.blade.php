@extends('components.modals.form-modal')
@section('modal-title','Crear Grupo')
@section('modal-content')
    <form class="" role="form"  id="group-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#group-form','/groups', "tableReload(); closeModal();") !!}
@endsection
