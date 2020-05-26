@extends('components.modals.form-modal')
@section('modal-title','Modificar Dispositivo')
@section('modal-content')
    <form class="" role="form"  id="device-form">
        @csrf
        @method('put')

        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control" id="internal_id" name="internal_id" value="{{ $device->internal_id }}">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $device->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select class="form-control m-b" name="device_type_id" id="device_type_id">
                <option value="" disabled="" selected="" >Seleccione...</option>
                @foreach($types as $type)
                    @if($type->id = $device->device_type_id)
                        <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                    @else
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#device-form','/devices/'.$device->id, "tableReload(); closeModal();") !!}
@endsection
