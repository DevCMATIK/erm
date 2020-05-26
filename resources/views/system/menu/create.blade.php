@extends('components.modals.form-modal')
@section('modal-title','Crear Menu')
@section('modal-content')
    <form class="" role="form"  id="menu-form">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Icono</label>
                    <input type="text" class="form-control"  name="icon" id="icon">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre del Item</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre de la Ruta</label>
                    <input type="text" class="form-control" id="route" name="route">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Item Padre</label>
                    <select class="form-control m-b" name="parent_id" id="parent_id">
                        <option value="">Item Principal</option>
                        @foreach($menus as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Roles </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            @foreach($roles as $r)
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="{{ $r->slug }}" name="roles[]">
                                    <span class="custom-control-label">{{ $r->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#menu-form','/menus', "tableReload(); closeModal();") !!}
@endsection
