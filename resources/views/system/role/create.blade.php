@extends('components.modals.form-modal')
@section('modal-title','Crear Role')
@section('modal-content')
    <form class="" role="form"  id="role-form">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control"  name="slug" id="slug">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#role-form','/roles', "tableReload(); closeModal();") !!}
@endsection
