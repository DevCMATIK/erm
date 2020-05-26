<h5 class="mt-3">{{ $sensor->name }}</h5>
<form id="sensor-range-form">
    @csrf
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Valor Maximo</label>
                <input type="text" class="form-control" name="max_value" value="{{ $sensor->max_value }}">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Escala Por Defecto</label>
                <select name="default_disposition" class="form-control">
                    @forelse($sensor->dispositions as $disposition)
                        @if($sensor->default_disposition && $sensor->default_disposition == $disposition->id)
                            <option value="{{ $disposition->id }}" selected>{{ $disposition->name }}</option>
                        @else
                            <option value="{{ $disposition->id }}">{{ $disposition->name }}</option>
                        @endif
                    @empty
                        <option value="" selected="" disabled>No hay opciones</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            @forelse($sensor->ranges as $range)
                <input type="hidden" name="color[]" value="{{ $range->color }}">
                <div class="border p-2 bg-{{ $range->color }}">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label">Min</label>
                                <input type="text" class="form-control" name="min[]" value="{{ $range->min }}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="form-label">max</label>
                                <input type="text" class="form-control" name="max[]" value="{{ $range->max }}">
                            </div>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Guardar Rangos</button>
    </div>
</form>
{!!  makeValidation('#sensor-range-form','/sensorRanges/'.$sensor->id, "") !!}

