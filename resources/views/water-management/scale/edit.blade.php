@extends('components.modals.form-modal')
@section('modal-title','Modificar Escala')
@section('modal-content')
    <form class="" role="form"  id="scale-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $scale->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Minimo</label>
            <input type="text" class="form-control"  name="min" value="{{ $scale->min }}">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Maximo</label>
            <input type="text" class="form-control" name="max" value="{{ $scale->max }}">
        </div>
        <div class="form-group">
            <label class="form-label">Decimales</label>
            <input type="text" class="form-control"  name="precision" value="{{ $scale->precision }}">
        </div>
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#scale-form','/scales/'.$scale->id, "tableReload(); closeModal();") !!}
@endsection

