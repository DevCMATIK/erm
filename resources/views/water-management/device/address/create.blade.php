@extends('components.modals.form-modal')
@section('modal-title','Crear Tipo de dispositivo')
@section('modal-content')
    <form class="" role="form"  id="address-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="register_type_id">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Configuracion</label>
            <select name="configuration_type" class="form-control">
                <option value="boolean">On/Off</option>
                <option value="scale">Escalas y Rangos</option>
            </select>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#address-form','/addresses', "tableReload(); closeModal();") !!}
@endsection
