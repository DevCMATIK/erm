@extends('components.modals.form-modal')
@section('modal-title','Crear Tipo de dispositivo')
@section('modal-content')
    <form class="" role="form"  id="device-type-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" id="model" name="model">
        </div>
        <div class="form-group">
            <label class="form-label">Marca</label>
            <input type="text" class="form-control" id="brand" name="brand">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#device-type-form','/device-types', "tableReload(); closeModal();") !!}
@endsection
