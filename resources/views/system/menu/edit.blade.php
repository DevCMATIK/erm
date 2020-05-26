@extends('components.modals.form-modal')
@section('modal-title','Modificar Menu')
@section('modal-content')
    <form class="" role="form"  id="menu-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Icono</label>
                    <input type="text" class="form-control"  name="icon" id="icon" value="{{ $menu->icon }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre del Item</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre de la Ruta</label>
                    <input type="text" class="form-control" id="route" name="route" value="{{ $menu->route }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Item Padre</label>
                    <select class="form-control m-b" name="parent_id" id="parent_id">
                        @if($menu->parent_id == null)
                            <option value="" selected >Item Principal</option>
                        @else
                            <option value="">Item Principal</option>
                        @endif
                        @foreach($menus as $m)
                            @if($m->id == $menu->parent_id)
                                <option value="{{ $m->id }}" selected>{{ $m->name }}</option>
                            @else
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endif
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
                                @if(in_array($r->slug,$menu->entityRolesAsArray()))
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="{{ $r->slug }}" name="roles[]">
                                        <span class="custom-control-label">{{ $r->name }}</span>
                                    </label>
                                @else
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="{{ $r->slug }}" name="roles[]">
                                        <span class="custom-control-label">{{ $r->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#menu-form','/menus/'.$menu->id, "tableReload(); closeModal();") !!}
@endsection
