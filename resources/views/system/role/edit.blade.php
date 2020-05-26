@extends('components.modals.form-modal')
@section('modal-title','Modificar Role')
@section('modal-content')
    <form class="" role="form"  id="role-form">
        @method('put')
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control"  name="slug" id="slug" value="{{ $role->slug }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}">
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#role-form','/roles/'.$role->id, "tableReload(); closeModal();") !!}
@endsection
