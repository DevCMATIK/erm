<div class="border p-2 my-1">
    <input type="hidden" name="row_id[]" id="row_{{ $row }}" value="{{ $row }}">
    <div class="row">
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Nombre Disposicion</label>
                <input type="text" class="form-control" name="name[]" id="name_{{ $row }}" value="">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Escala</label>
                <select class="form-control" name="scale_id[]" id="scale_id_{{ $row }}">
                    @foreach($scales as $scale)
                        <option value="{{ $scale->id }}">{{ $scale->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Unidad de Medida</label>
                <select name="unit_id[]" id="unit_id_{{ $row }}"  class="form-control">
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">N. Decimales</label>
                <input type="text" class="form-control" name="precision[]" id="precision_{{ $row }}">
            </div>
        </div>
    </div>
    <div class="row mt-2">



        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Minimo Ing.</label>
                <input type="text" class="form-control" name="sensor_min[]" id="scale_min_{{ $row }}">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Maximo Ing.</label>
                <input type="text" class="form-control" name="sensor_max[]" id="scale_max_{{ $row }}">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Minimo (Sensor)</label>
                <input type="text" class="form-control" name="scale_min[]" id="sensor_min_{{ $row }}">
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label class="form-label">Valor Maximo (Sensor)</label>
                <input type="text" class="form-control" name="scale_max[]" id="sensor_max_{{ $row }}">
            </div>
        </div>
    </div>
</div>
