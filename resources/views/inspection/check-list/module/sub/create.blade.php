@extends('components.modals.form-modal')
@section('modal-title','Crear Modulo de Check List')
@section('modal-content')
    <form class="" role="form"  id="check-list-form">
        @csrf
        <input type="hidden" name="module_id" value="{{ $module->id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Columnas</label>
            <select name="columns" class="form-control">
                <option value="1">1 Columna</option>
                <option value="2">2 Columnas</option>
                <option value="3">3 Columnas</option>
            </select>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-list-form','/check-list-sub-modules', "tableReload(); closeModal();") !!}
@endsection
