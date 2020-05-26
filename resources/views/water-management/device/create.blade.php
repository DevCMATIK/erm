@extends('components.modals.form-modal')
@section('modal-title','Crear Dispositivo')
@section('modal-content')
    <form class="" role="form"  id="device-form">
        @csrf
        <input type="hidden" name="check_point_id" value="{{ $check_point_id }}">
        <div class="form-group">
            <label class="form-label">Id Interno</label>
            <input type="text" class="form-control" id="internal_id" name="internal_id">
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select class="form-control m-b" name="device_type_id" id="device_type_id">
                <option value="" disabled="" selected="" >Seleccione...</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#device-form','/devices', "tableReload(); closeModal();") !!}
@endsection
