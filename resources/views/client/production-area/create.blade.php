@extends('components.modals.form-modal')
@section('modal-title','Crear Area de produccion')
@section('modal-content')
    <form class="" role="form"  id="production-area-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#production-area-form','/production-areas', "tableReload(); closeModal();") !!}
@endsection
