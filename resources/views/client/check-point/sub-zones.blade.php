@if($check_point)
    @forelse($sub_zones as $sub_zone)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" value="{{ $sub_zone->id }}" class="custom-control-input" id="check_{{ $sub_zone->id }}" name="sub_zone_id[]" @if($check_point->sub_zones->contains($sub_zone->id)) checked @endif>
            <label class="custom-control-label fs-xs" for="check_{{ $sub_zone->id }}">{{ $sub_zone->name }}</label>
        </div>
    @empty
        <div class="alert alert-info">
            No ha creado sub Zonas
        </div>
    @endforelse
@else
    @forelse($sub_zones as $sub_zone)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" value="{{ $sub_zone->id }}" class="custom-control-input" id="check_{{ $sub_zone->id }}" name="sub_zone_id[]">
            <label class="custom-control-label fs-xs" for="check_{{ $sub_zone->id }}">{{ $sub_zone->name }}</label>
        </div>
    @empty
        <div class="alert alert-info">
            No ha creado sub Zonas
        </div>
    @endforelse
@endif
