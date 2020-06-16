<h5 class="p-2 bg-primary text-white mb-4">
    {{ $sensor->name }} - {{ $sensor->address->name }}{{ $sensor->address_number }}

    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-triggers?sensor_id={{ $sensor->id }}" target="_blank"><i class="fas fa-link"></i> Triggers</a>
    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-alarms?sensor_id={{ $sensor->id }}" target="_blank"><i class="fas fa-exclamation-triangle"></i> Alarmas</a>

</h5>
<script>
    function addScale()
    {
        let row = parseInt($('#last_row').val());
        let newRow = row + 1;
        $.get('/addNewScale/'+newRow, function(data) {
            $('#scales-div').append(data);
            $('#last_row').val(newRow);
        });
    }

    function deleteDisposition(sensor,disposition)
    {
        $.get('/deleteDisposition/'+disposition, function(data) {
            getScaleForm(sensor);
        });
    }

    function createLastAverage() {
        let average = $('#last_average').val();
        $.get('/createAverageForSensor/{{ $sensor->id }}/'+average, function(data){
            getScaleForm({{ $sensor->id }});
        });
    }
</script>

<form id="scale-form">
    @csrf
    <div class="row m-2 pb-2">
        <div class="col-xl-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="enable" name="enabled"
                       @if($sensor->enabled ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="enable">Habilitar</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="alarm" name="has_alarm"
                       @if($sensor->has_alarm ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="alarm">Alarma</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="historial" name="historial"
                       @if($sensor->historial ==1) checked @endif >
                <label class="custom-control-label fs-xl" for="historial">Historico</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="fix_values_out_of_range" name="fix_values_out_of_range"
                       @if($sensor->fix_values_out_of_range == 1) checked @endif >
                <label class="custom-control-label fs-xl" for="fix_values_out_of_range">Fix Values</label>
            </div>
        </div>
        <div class="col-xl-3">
            @if(isset($sensor->average) && optional($sensor->average)->last_average != null)
                <p><small class="font-weight-bolder">Última Media: </small>{{ $sensor->average->last_average }}</p>

            @else
                <div class="form-group">
                    <label class="form-label">Última Media</label>
                    <input type="text" class="form-control" id="last_average" onblur="createLastAverage()">
                </div>
            @endif
        </div>
    </div>
    <div class="row p-2 border-top">
        <div class="col-xl-4">
            <label class="custom-control custom-checkbox">
                <input type="checkbox"  class="custom-control-input" value="1" @if($sensor->fix_values === 1) checked @endif name="fix_values">
                <span class="custom-control-label">Reparar valores erróneos</span>
            </label>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label class="form-label">Valor Mínimo</label>
                <input type="text" class="form-control" id="fix_min_value" name="fix_min_value" value="{{ $sensor->fix_min_value }}">
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label class="form-label">Valor máximo</label>
                <input type="text" class="form-control" id="fix_max_value" name="fix_max_value" value="{{ $sensor->fix_max_value }}">
            </div>
        </div>
    </div>
    <div class="row p-2">
        <div class="col-12 p-2" id="scales-div">
            <h6 class="text-primary border-bottom">Disposiciones <a href="javascript:void(0)" class="btn btn-info float-right btn-xs" onclick="addScale()">Agregar nueva</a></h6>
            <input type="hidden" id="last_row" value="1">

            @forelse($sensor->dispositions as $disposition)
                @if ($loop->last)
                    <script>
                        $('#last_row').val({{ $loop->iteration }});
                    </script>
                @endif
                    <div class="border p-2 my-1">
                        <h5> {{ $disposition->name }}
                            <a href="javascript:void(0)" onclick="deleteDisposition({{ $sensor->id }}, {{ $disposition->id }})" class="btn btn-danger float-right btn-xs "><i class="fas fa-times"></i></a>
                            <a href="/testValue/{{ $sensor->id }}/{{ $disposition->id }}" {!! makeLinkRemote() !!}  class="btn btn-info float-right btn-xs "><i class="fas fa-eye"></i></a>
                            <a href="/disposition-lines/{{ $disposition->id }}" {!! makeLinkRemote() !!}  class="btn btn-secondary float-right btn-xs "><i class="fas fa-chart-line"></i></a>
                        </h5>
                        <input type="hidden" name="row_id[]" id="row_{{ $loop->iteration }}" value="{{ $loop->iteration }}">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Nombre Disposicion</label>
                                    <input type="text" class="form-control" name="name[]" id="name_{{ $loop->iteration }}" value="{{ $disposition->name }}">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Escala</label>
                                    <select class="form-control" name="scale_id[]" id="scale_id_{{ $loop->iteration }}">
                                        @foreach($scales as $scale)
                                            @if($scale->id == $disposition->scale_id)
                                                <option value="{{ $scale->id }}" selected>{{ $scale->name }}</option>
                                                @else
                                                <option value="{{ $scale->id }}">{{ $scale->name }}</option>
                                                @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Unidad de Medida</label>
                                    <select name="unit_id[]" id="unit_id_{{ $loop->iteration }}"  class="form-control">
                                        @foreach($units as $unit)
                                            @if($unit->id == $disposition->unit_id)
                                                <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                            @else
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">N. Decimales</label>
                                    <input type="text" class="form-control" name="precision[]" id="precision_{{ $loop->iteration }}" value="{{ $disposition->precision ?? 0 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">



                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Minimo Ing.</label>
                                    <input type="text" class="form-control" name="sensor_min[]" id="scale_min_{{ $loop->iteration }}" value="{{ $disposition->sensor_min }}">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Maximo Ing.</label>
                                    <input type="text" class="form-control" name="sensor_max[]" id="scale_max_{{ $loop->iteration }}" value="{{ $disposition->sensor_max }}">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Minimo (Sensor)</label>
                                    <input type="text" class="form-control" name="scale_min[]" id="sensor_min_{{ $loop->iteration }}" value="{{ $disposition->scale_min }}">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Maximo (Sensor)</label>
                                    <input type="text" class="form-control" name="scale_max[]" id="sensor_max_{{ $loop->iteration }}" value="{{ $disposition->scale_max }}">
                                </div>
                            </div>
                        </div>
                    </div>

            @empty
                <script> addScale();</script>
            @endforelse


        </div>

    </div>
    <div class="form-group p-2">
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
</form>

{!!  makeValidation('#scale-form','/storeSensorScale/'.$sensor->id, "getScaleForm(".$sensor->id.");") !!}
