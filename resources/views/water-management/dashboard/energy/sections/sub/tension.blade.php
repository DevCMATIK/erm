<div class="row my-3">
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-xs active" onclick="tensionOptions('average');" data-toggle="tooltip" data-original-title="Promedio">
                        <input type="radio" name="tensionOptions" value="average" checked="checked"> <i class="fas fa-chart-line"></i>
                    </label>
                    <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Detalle">
                        <input type="radio" name="tensionOptions" value="detail" > <i class="fas fa-bars"></i>
                    </label>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-xs active fs-nano" onclick="handleTension('LL');">
                        <input type="radio" name="TensionType" value="LL"  checked="checked"> LL
                    </label>
                    <label class="btn btn-outline-secondary btn-xs fs-nano" onclick="handleTension('LN');">
                        <input type="radio" name="TensionType" value="LN" > LN
                    </label>
                </div>
            </div>
        </div>

        <div id="ee-tension-l-l-L1-L2-container" class="tension-ll">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-primary-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-tension-l-l-L2-L3-container" class="tension-ll">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-primary-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-tension-l-l-L3-L1-container" class="tension-ll">
            @include('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-primary-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
               'mb' => 'mb-1'
            ])
        </div>

        <div id="ee-tension-l-n-L1-N-container" class="tension-ln">

        </div>
        <div id="ee-tension-l-n-L2-N-container" class="tension-ln">

        </div>
        <div id="ee-tension-l-n-L3-N-container" class="tension-ln">

        </div>

    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12" id="tensionChartContainer">

    </div>
</div>
