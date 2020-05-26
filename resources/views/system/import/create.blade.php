@extends('components.modals.form-modal')
@section('modal-title','Crear Modulo de importacion')
@section('modal-content')
    <form class="" role="form"  id="import-form">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="name" id="name">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Offset</label>
                    <input type="text" class="form-control"  name="offset" id="offset">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-label">Encabezados</label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="ignore_header">
                        <span class="custom-control-label">Ignorar</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="col-lg-4">
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
        <div class="form-group">
            <label class="form-label">
                Campos
                <span class="pull-right">
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onClick="addField()"><i class="fas fa-plus"></i> Agregar Campo</a>
                </span>
            </label>
            <div class="fields-list">
                <input type="text" class="form-control fields" placeholder="nombre del campo" name="fields[]">
            </div>
        </div>
    </form>
    <script>
        function addField(){
            $('.fields-list').append('<div class="input-group fields"><input type="text" class="form-control " placeholder="nombre del campo" name="fields[]"><span class="input-group-btn"><button type="button" onClick=" $(this).closest(\'div\').remove();" class="btn btn-danger removeItem">X</button></span><br></div>');
        }

    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#import-form','/imports', "tableReload(); closeModal();") !!}
@endsection
