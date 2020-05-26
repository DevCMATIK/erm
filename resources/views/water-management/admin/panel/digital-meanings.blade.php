<h5 class="mt-3">{{ $s->sensor->name }}</h5>
<form id="sensor-range-form">
    @csrf
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Flecha Arriba cuando (1 o 0)</label>
                <input type="text" class="form-control" name="means_up" value="{{ $s->means_up }}">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">Flecha Abajo cuando (1 o 0)</label>
                <input type="text" class="form-control" name="means_down" value="{{ $s->means_down }}">
            </div>
        </div>
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>
{!!  makeValidation('#sensor-range-form','/updateDigitalMeanings/'.$s->id, "") !!}

