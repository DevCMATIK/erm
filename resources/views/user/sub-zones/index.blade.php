@extends('components.modals.form-modal')
@section('modal-title','Usuario: '.$user->full_name)
@section('modal-content')
    <script>

        function getSubZones(user_id) {
            $.get('/userSubZones/detail/'+user_id, function(html) {
                $('#user-sub-zones').html(html);
            })
        }

    </script>
    <form action=""  role="form"  id="user-production-areas-form">
        @csrf
        <h5>Areas de Produccion del usuario</h5>
        <div class="form-group">
            @foreach($productionAreas as $productionArea)
                @if($user->inProductionArea($productionArea->id))
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" checked="checked" class="custom-control-input" value="{{ $productionArea->id }}" name="production_areas[]">
                        <span class="custom-control-label">{{ $productionArea->name }}</span>
                    </label>
                @else
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="{{ $productionArea->id }}" name="production_areas[]">
                        <span class="custom-control-label">{{ $productionArea->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"> Guardar Areas de Produccion</button>
        </div>
    </form>
    <hr>
    <div id="user-sub-zones">
        <h5>Sub Zonas Asignadas a usuario</h5>
        @if($user->production_areas()->count() > 0 )

            <script>getSubZones({{ $user->id }});</script>
        @else
            <div class="alert alert-info">
                No ha asignado areas de produccion al usuario, seleccione almenos una para poder administrar sus zonas
            </div>
        @endif
    </div>

@endsection
@section('modal-validation')

    {!!  makeValidation('#user-production-areas-form','/userProductionAreas/'.$user->id, "getSubZones(".$user->id.")") !!}
@endsection
@section('modal-width','60')
@section('no-submit')
    .
@endsection
