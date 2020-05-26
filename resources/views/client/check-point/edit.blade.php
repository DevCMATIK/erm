@extends('components.modals.form-modal')
@section('modal-title','Modificar Punto de control')
@section('modal-content')
    <form class="" role="form"  id="check-point-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $checkPoint->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Zonas</label>
            <select class="form-control m-b" name="zone_id" id="zone_id" onchange="getSubZones()">
                <option value="" disabled="" selected="" >Seleccione...</option>
                @foreach($zones as $z)
                    @if( $z->id == $checkPoint->sub_zones->first()->zone->id)
                        <option value="{{ $z->id }}" selected>{{ $z->name }}</option>
                    @else
                        <option value="{{ $z->id }}">{{ $z->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-lg-12" id="sub_zones_container">

            </div>
        </div>
    </form>

    <script>
        getSubZones();
        function getSubZones() {
            let zone = $('#zone_id').val();
            $.get('/getSubZones/'+zone+'/{{ $checkPoint->id }}',function(data) {
                $('#sub_zones_container').html(data);
            });
        }
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#check-point-form','/check-points/'.$checkPoint->id, "tableReload(); closeModal();") !!}
@endsection
