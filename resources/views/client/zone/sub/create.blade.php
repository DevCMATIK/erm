@extends('components.modals.form-modal')
@section('modal-title','Crear Sub Zona')
@section('modal-content')
    <form class="" role="form"  id="sub-zone-form">
        @csrf
        <input type="hidden" name="zone" value="{{ $zone }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#sub-zone-form','/sub-zones', "tableReload(); closeModal();") !!}
@endsection
