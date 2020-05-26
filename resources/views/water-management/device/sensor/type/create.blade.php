@extends('components.modals.form-modal')
@section('modal-title','Crear Tipo de Sensor')
@section('modal-content')
    <form class="" role="form"  id="type-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Intervalo</label>
            <select name="interval" class="form-control">
                <option value="" selected="" disabled>Seleccione...</option>
                <option value="1">Cada 1 Minuto</option>
                <option value="5">Cada 5 Minutos</option>
                <option value="10">Cada 10 Minutos</option>
                <option value="15">Cada 15 Minutos</option>
                <option value="30">Cada 30 Minutos</option>
                <option value="60">Cada 60 Minutos</option>
            </select>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/sensor-types', "tableReload(); closeModal();") !!}
@endsection
