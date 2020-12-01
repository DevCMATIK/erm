<div class="row my-3">
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
        <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary btn-xs active" onclick="tensionOptions('average');" data-toggle="tooltip" data-original-title="Potencia Líneas">
                <input type="radio" name="tensionOptions" value="average" checked="checked"> P. Líneas
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Activa">
                <input type="radio" name="tensionOptions" value="detail" > Act
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Reactiva">
                <input type="radio" name="tensionOptions" value="detail" > Reac
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Aparente">
                <input type="radio" name="tensionOptions" value="detail" > Apa
            </label>
        </div>

        <div id="ee-p-act-u-P1-container" class="p-avr">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-danger-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>
        <div id="ee-p-act-u-P2-container" class="p-avr">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-danger-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>
        <div id="ee-p-act-u-P3-container" class="p-avr">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-danger-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-p-activa-container" class="power-data">

        </div>
        <div id="ee-p-reactiva-container" class="power-data">

        </div>
        <div id="ee-p-aparente-container" class="power-data">

        </div>

    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12" id="powerChartContainer">

    </div>
</div>

<script>

</script>
