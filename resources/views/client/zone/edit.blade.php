@extends('components.modals.form-modal')
@section('modal-title','Modificar Zona')
@section('modal-content')
    <form class="" role="form"  id="zone-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $zone->name }}">
        </div>

        <div class="form-group">
            <label class="form-label">Nombre en Menu</label>
            <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $zone->display_name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#zone-form','/zones/'.$zone->id, "tableReload(); closeModal();") !!}
@endsection
