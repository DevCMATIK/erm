<h5>Sensores seleccionados</h5>

@forelse($sensors as $sensor)

    <div class="list-group-item py-1 px-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" checked class="custom-control-input" value="{{ $sensor->id }}" name="sensor_id[]">
            <span class="custom-control-label">{{ $sensor->device->sub_element->first()->element->sub_zone->name }} -
        {{ $sensor->device->name}} -
        {{ $sensor->full_address}}</span>
        </label>

    </div>
    @empty
    <p>No ha seleccionado sensores</p>
@endforelse
