@extends('components.modals.form-modal')
@section('modal-title','Modificar direccion')
@section('modal-content')
    <form class="" role="form"  id="address-form">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $address->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control"  name="register_type_id" value="{{ $address->register_type_id }}">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Configuracion</label>
            <select name="configuration_type" class="form-control">
                @switch($address->configuration_type)
                    @case('boolean')
                        <option value="boolean" selected>On/Off</option>
                        <option value="scale">Escalas y Rangos</option>
                    @break
                    @case('scale')
                        <option value="boolean">On/Off</option>
                        <option value="scale" selected>Escalas y Rangos</option>
                    @break
                @endswitch
            </select>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#address-form','/addresses/'.$address->id, "tableReload(); closeModal();") !!}
@endsection
