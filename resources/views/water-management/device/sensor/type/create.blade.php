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
                <option value="77">Al Cambio</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valor Mínimo</label>
            <input type="text" class="form-control" id="min_value" name="min_value">
        </div>
        <div class="form-group">
            <label class="form-label">Valor máximo</label>
            <input type="text" class="form-control" id="max_value" name="max_value">
        </div>
        <h5><i class="fas fa-cog"></i> Opciones</h5>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input main-control" name="is_exportable" checked id="is_exportable" value="1">
            <label class="custom-control-label" for="is_exportable">Exportable</label>
        </div>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input main-control" name="is_dga"  id="is_dga" value="1">
            <label class="custom-control-label" for="is_dga">Para DGA</label>
        </div>
       <div class="form-group mt-3">
           <h5><i class="fas fa-th"></i> Tipo de sensor</h5>
           <div class="custom-control custom-radio">
               <input type="radio" class="custom-control-input main-control" name="sensor_type" id="level"  value="level">
               <label class="custom-control-label" for="level">Es Nivel</label>
           </div>
           <div class="custom-control custom-radio">
               <input type="radio" class="custom-control-input main-control" name="sensor_type" id="tote"  value="tote">
               <label class="custom-control-label" for="tote">Es Totalizador</label>
           </div>
           <div class="custom-control custom-radio">
               <input type="radio" class="custom-control-input main-control" name="sensor_type" id="flow"  value="flow">
               <label class="custom-control-label" for="flow">Es Caudal</label>
           </div>
           <div class="custom-control custom-radio">
               <input type="radio" class="custom-control-input main-control" name="sensor_type" checked id="other"  value="other">
               <label class="custom-control-label" for="other">Otro</label>
           </div>
       </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/sensor-types', "tableReload(); closeModal();") !!}
@endsection
