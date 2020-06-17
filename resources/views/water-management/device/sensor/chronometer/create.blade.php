@extends('components.modals.form-modal')
@section('modal-title','Crear cronómetro para el sensor: '.$sensor->name)
@section('modal-content')
    <form class="" role="form"  id="chronometer-form">
        @csrf
        <input type="hidden" name="sensor_id" value="{{ $sensor->id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="form-group">
            <label class="form-label">Ejecutar cuando el valor sea igual que</label>
            <input type="text" class="form-control" id="equals_to" name="equals_to">
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#chronometer-form','/sensor-chronometers', "tableReload(); closeModal();") !!}
@endsection
