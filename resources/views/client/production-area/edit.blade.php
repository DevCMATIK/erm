@extends('components.modals.form-modal')
@section('modal-title','Modificar area de produccion')
@section('modal-content')
    <form class="" role="form"  id="role-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $productionArea->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#role-form','/production-areas/'.$productionArea->id, "tableReload(); closeModal();") !!}
@endsection
