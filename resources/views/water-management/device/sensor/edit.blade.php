@extends('components.modals.form-modal')
@section('modal-title','Modificar Sensor')
@section('modal-content')
    <form class="" role="form"  id="sensor-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $sensor->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo Registro</label>
            <select name="address_id" class="form-control">
                @foreach($addresses as $address)
                    @if($sensor->address_id == $address->id)
                        <option value="{{ $address->id }}" selected>{{ $address->name }}</option>
                    @else
                        <option value="{{ $address->id }}">{{ $address->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Direccion</label>
            <input type="text" class="form-control"  name="address_number" value="{{ $sensor->address_number }}">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo de Sensor</label>
            <select name="type_id" class="form-control">
                @foreach($types as $type)
                    @if($sensor->type_id == $type->id)
                        <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                    @else
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valor Mínimo</label>
            <input type="text" class="form-control" id="fix_min_value" name="fix_min_value" value="{{ $sensor->fix_min_value }}">
        </div>
        <div class="form-group">
            <label class="form-label">Valor máximo</label>
            <input type="text" class="form-control" id="fix_max_value" name="fix_max_value" value="{{ $sensor->fix_max_value }}">
        </div>
        <label class="custom-control custom-checkbox">
            <input type="checkbox"  class="custom-control-input" value="1" @if($sensor->fix_values === 1) checked @endif name="fix_values">
            <span class="custom-control-label">Reparar valores erróneos</span>
        </label>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#sensor-form','/sensors/'.$sensor->id, "tableReload(); closeModal();") !!}
@endsection
