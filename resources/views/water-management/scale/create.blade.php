@extends('components.modals.form-modal')
@section('modal-title','Crear Escala')
@section('modal-content')
    <form class="" role="form"  id="scale-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Minimo</label>
            <input type="text" class="form-control"  name="min">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Maximo</label>
            <input type="text" class="form-control" name="max">
        </div>
        <div class="form-group">
            <label class="form-label">Decimales</label>
            <input type="text" class="form-control"  name="precision">
        </div>
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#scale-form','/scales', "tableReload(); closeModal();") !!}
@endsection
