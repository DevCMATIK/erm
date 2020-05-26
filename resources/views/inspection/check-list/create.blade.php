@extends('components.modals.form-modal')
@section('modal-title','Crear check List')
@section('modal-content')
    <form class="" role="form"  id="checkList-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Punto de Control</label>
            <select name="check_point_type_id" class="form-control">
                <option value="" selected="" disabled="">Seleccione...</option>
                @forelse($checkPoints as $checkPoint)
                    <option value="{{ $checkPoint->id }}">{{ $checkPoint->name }}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#checkList-form','/check-lists', "tableReload(); closeModal();") !!}
@endsection
