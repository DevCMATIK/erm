@extends('components.modals.form-modal')
@section('modal-title','Crear Area')
@section('modal-content')
    <form class="" role="form"  id="area-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Icono</label>
            <input type="text" class="form-control" id="icon" name="icon">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#area-form','/areas', "tableReload(); closeModal();") !!}
@endsection
