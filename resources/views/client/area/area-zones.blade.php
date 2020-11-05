@extends('components.modals.form-modal')
@section('modal-title','Zonas del Area '.$area->name)
@section('modal-content')
    <form class="" role="form"  id="area-zones-form">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="form-group">
                    <label class="form-label">Zonas </label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="form-group">
                            @foreach($zones as $zone)
                                @if($area->inZone($zone->id))
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" checked="checked" class="custom-control-input" value="{{ $zone->id }}" name="zones[]">
                                        <span class="custom-control-label">{{ $zone->name }}</span>
                                    </label>
                                @else
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="{{ $zone->id }}" name="zones[]">
                                        <span class="custom-control-label">{{ $zone->name }}</span>
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
    {!!  makeValidation('#area-zones-form','/area-zones/'.$area->id, "tableReload(); closeModal(); ") !!}
@endsection
