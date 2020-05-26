@extends('components.modals.form-modal')
@section('modal-title','Zonas del Area de Produccion: '.$productionArea->name)
@section('modal-content')
    <form class="" role="form"  id="productionArea-zones-form">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Zonas </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            @foreach($zones as $zone)
                                @if($productionArea->inZone($zone->id))
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
    {!!  makeValidation('#productionArea-zones-form','/productionArea/zones/'.$productionArea->id, "closeModal();") !!}
@endsection
