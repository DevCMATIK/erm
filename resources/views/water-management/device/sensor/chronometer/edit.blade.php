@extends('components.modals.form-modal')
@section('modal-title','Modificar cronómetro para el sensor: '.$sensor->name)
@section('modal-content')
    <form class="" role="form"  id="chronometer-form">
        @csrf
        @method('put')
        <input type="hidden" name="sensor_id" value="{{ $sensor->id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $chronometer->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Ejecutar cuando el valor sea igual que</label>
            <input type="text" class="form-control" id="equals_to" name="equals_to" value="{{ $chronometer->equals_to }}">
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#chronometer-form','/sensor-chronometers/'.$chronometer->id, "tableReload(); closeModal();") !!}
@endsection
