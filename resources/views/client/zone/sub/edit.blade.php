@extends('components.modals.form-modal')
@section('modal-title','Modificar Sub Zona')
@section('modal-content')
    <form class="" role="form"  id="sub-zone-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $zone->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#sub-zone-form','/sub-zones/'.$zone->id, "tableReload(); closeModal();") !!}
@endsection
