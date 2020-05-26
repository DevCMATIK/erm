@extends('components.modals.form-modal')
@section('modal-title','Modificar tcheck list')
@section('modal-content')
    <form class="" role="form"  id="checkList-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Punto de Control</label>
            <select name="check_point_type_id" class="form-control">
                <option value="" selected="" disabled="">Seleccione...</option>
                @forelse($checkPoints as $checkPoint)
                    @if($checkPoint->id == $checkList->check_point_type_id)
                        <option value="{{ $checkPoint->id }}" selected>{{ $checkPoint->name }}</option>
                    @else
                        <option value="{{ $checkPoint->id }}">{{ $checkPoint->name }}</option>
                    @endif
                @empty
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" value="{{ $checkList->name }}" name="name">
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#type-form','/check-lists/'.$checkList->id, "tableReload(); closeModal();") !!}
@endsection
