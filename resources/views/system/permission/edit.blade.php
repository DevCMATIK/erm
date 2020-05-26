@extends('components.modals.form-modal')
@section('modal-title','Modificar Permiso')
@section('modal-content')
    <form class="" role="form"  id="permission-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control"  name="slug" id="slug" value="{{ $permission->slug }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Listado de permisos</label>
                    <textarea name="list" class="form-control" rows="3">{{ $permission->list }}</textarea>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#permission-form','/permissions/'.$permission->id, "tableReload(); closeModal();") !!}
@endsection
