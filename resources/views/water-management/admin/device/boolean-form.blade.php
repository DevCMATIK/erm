<h5 class="p-2 bg-primary text-white mb-6">
    {{ $sensor->name }} - {{ $sensor->address->name }}{{ $sensor->address_number }}

    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-triggers?sensor_id={{ $sensor->id }}" target="_blank"><i class="fas fa-link"></i> Triggers</a>
    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-alarms?sensor_id={{ $sensor->id }}" target="_blank"><i class="fas fa-exclamation-triangle"></i> Alarmas</a>

</h5>

<form id="label-form">
    @csrf
    <div class="row border-bottom m-2 pb-2">
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="enable" name="enabled"
                    @if($sensor->enabled ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="enable">Habilitar</label>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="alarm" name="has_alarm"
                       @if($sensor->has_alarm ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="alarm">Alarma</label>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="historial" name="historial"
                       @if($sensor->historial ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="historial">Historico</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">Nombre</label>
        <input type="text" class="form-control" name="name" value="{{ optional($sensor->label)->name }}">
    </div>
    <div class="row p-2">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">ON</label>
                <input type="text" class="form-control" name="on_label" value="{{ optional($sensor->label)->on_label }}">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">OFF</label>
                <input type="text" class="form-control" name="off_label" value="{{ optional($sensor->label)->off_label }}">
            </div>
        </div>
    </div>
    <div class="form-group p-2 mb-6">
        <button type="submit" class="btn btn-primary float-right">Guardar</button>
    </div>
</form>
{!!  makeValidation('#label-form','/storeSensorLabel/'.$sensor->id, "getBooleanForm(".$sensor->id.");") !!}
