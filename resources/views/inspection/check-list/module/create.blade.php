@extends('components.modals.form-modal')
@section('modal-title','Crear Modulo de Check List')
@section('modal-content')
    <form class="" role="form"  id="check-list-form">
        @csrf
        <input type="hidden" name="check_list_id" value="{{ $checkList->id }}">
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-list-form','/check-list-modules', "tableReload(); closeModal();") !!}
@endsection
