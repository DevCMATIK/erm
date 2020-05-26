@extends('components.modals.form-modal')
@section('modal-title','Modificar Area')
@section('modal-content')
    <form class="" role="form"  id="area-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $area->name }}">
        </div>

        <div class="form-group">
            <label class="form-label">Icono</label>
            <input type="text" class="form-control" id="icon" name="icon" value="{{ $area->icon }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#area-form','/areas/'.$area->id, "tableReload(); closeModal();") !!}
@endsection
