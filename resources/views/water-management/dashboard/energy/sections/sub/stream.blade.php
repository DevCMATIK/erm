<div class="row my-3">
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12" id="stream-data-container">
        <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary btn-xs active" onclick="streamOptions('average');" data-toggle="tooltip" data-original-title="Promedio">
                <input type="radio" name="streamOptions" value="average" checked="checked"> <i class="fas fa-chart-line"></i>
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="streamOptions('detail');" data-toggle="tooltip" data-original-title="Detalle">
                <input type="radio" name="streamOptions" value="detail" > <i class="fas fa-bars"></i>
            </label>
        </div>

        <div id="ee-corriente-L1-container">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-warning-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
                'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-corriente-L2-container">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-warning-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-corriente-L3-container">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-warning-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>
    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12" id="streamChartContainer">

    </div>
</div>
