@extends('components.modals.form-modal')
@section('modal-title','Modificar Sub Modulo de check list')
@section('modal-content')
    <form class="" role="form"  id="check-list-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $sub->name }}">
        </div>

        <div class="form-group">
            <label class="form-label">Columnas</label>
            <select name="columns" class="form-control">
                @switch($sub->columns)
                    @case(1)
                        <option value="1" selected>1 Columna</option>
                        <option value="2">2 Columnas</option>
                        <option value="3">3 Columnas</option>
                    @break
                    @case(2)
                        <option value="1">1 Columna</option>
                        <option value="2" selected>2 Columnas</option>
                        <option value="3">3 Columnas</option>
                    @break
                    @case(3)
                        <option value="1">1 Columna</option>
                        <option value="2">2 Columnas</option>
                        <option value="3" selected>3 Columnas</option>
                    @break
                @endswitch
            </select>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-list-form','/check-list-sub-modules/'.$sub->id, "tableReload(); closeModal();") !!}
@endsection
