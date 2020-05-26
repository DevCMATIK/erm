@extends('components.modals.form-modal')
@section('modal-title','Crear Control')
@section('modal-content')
    <form class="" role="form"  id="control-form">
        @csrf
        <input type="hidden" name="sub_module_id" value="{{ $subModule->id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select name="type" class="form-control">
                <option value="text">Texto</option>
                <option value="radio">Radio</option>
                <option value="check">CheckBox</option>
                <option value="combo">Combo</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valores (opcional)</label>
            <input type="text" class="form-control" id="values" name="values">
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Metrica (opcional)</label>
                    <input type="text" class="form-control" id="metric" name="metric">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Es requerido</label>
                    <select name="is_required" class="form-control">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#control-form','/check-list-controls', "tableReload(); closeModal();") !!}
@endsection
