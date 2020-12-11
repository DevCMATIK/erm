@extends('components.modals.form-modal')
@section('modal-title','Crear Punto de control')
@section('modal-content')
    <form class="" role="form"  id="check-point-form">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="form-group border-bottom">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Zonas</label>
            <select multiple class="form-control m-b" name="zone_id" id="zone_id" onchange="getSubZones()">
                <option value="" disabled="" selected="" >Seleccione...</option>
                @foreach($zones as $z)
                    <option value="{{ $z->id }}">{{ $z->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-lg-12" id="sub_zones_container">

            </div>
        </div>
    </form>

    <script>
        function getSubZones() {
            let zone = $('#zone_id').val();
            $.get('/getSubZones/'+zone,function(data) {
                $('#sub_zones_container').html(data);
            });
        }
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-point-form','/check-points', "tableReload(); closeModal();") !!}
@endsection
