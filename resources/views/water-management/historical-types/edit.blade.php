@extends('components.modals.form-modal')
@section('modal-title','Modificar Tipo historico')
@section('modal-content')
    <form class="" role="form"  id="historical_type-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="internal_id" value="{{ $historical->internal_id }}">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $historical->name }}">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#historical_type-form','/historical-types/'.$historical->id, "tableReload(); closeModal();") !!}
@endsection
