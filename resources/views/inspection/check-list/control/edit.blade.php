@extends('components.modals.form-modal')
@section('modal-title','Modificar Control')
@section('modal-content')
    <form class="" role="form"  id="control-form">
        @csrf

        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $control->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <select name="type" class="form-control">
                @switch($control->type)
                    @case('text')
                    <option value="text" selected>Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo">Combo</option>
                    @break
                    @case('radio')
                    <option value="text">Texto</option>
                    <option value="radio" selected>Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo">Combo</option>
                    @break
                    @case('check')
                    <option value="text">Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check" selected>CheckBox</option>
                    <option value="combo" >Combo</option>
                    @break
                    @case('combo')
                    <option value="text">Texto</option>
                    <option value="radio">Radio</option>
                    <option value="check">CheckBox</option>
                    <option value="combo" selected>Combo</option>
                    @break
                @endswitch
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Valores (opcional)</label>
            <input type="text" class="form-control" id="values" name="values" value="{{ $control->values }}">
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Metrica (opcional)</label>
                    <input type="text" class="form-control" id="metric" name="metric" value="{{ $control->metric }}">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Es requerido</label>
                    <select name="is_required" class="form-control">
                        @if($control->is_required)
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        @else
                            <option value="1">Si</option>
                            <option value="0" selected>No</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#control-form','/check-list-controls/'.$control->id, "tableReload(); closeModal();") !!}
@endsection
