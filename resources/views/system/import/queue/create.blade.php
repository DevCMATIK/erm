@extends('layouts.modal.layout')
@section('modal-icon','fa-list-ol')
@section('modal-title','Crear Sequencia de importacion')
@section('modal-content')
    <form class="" role="form"  id="queuedImports-form">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="name" id="name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Modulos de importacion </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            @foreach($imports as $i)
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="{{ $i->id }}" name="imports[]">
                                    <span class="custom-control-label">{{ $i->name }}</span>
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
    {!!  makeValidation('#queuedImports-form','/queuedImports', "tableReload(); closeModal();") !!}
@endsection
@section('modal-width','50')
