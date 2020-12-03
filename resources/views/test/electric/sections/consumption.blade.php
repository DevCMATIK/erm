<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="consumption" >
        @include('test.electric.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 85423,
            'measure' => 'kWh',
            'title' => 'Consumo mes actual',
            'icon' => 'fa-calendar'
        ])
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-consumption" >
        @include('test.electric.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 85122,
            'measure' => 'kWh',
            'title' => 'Consumo Mes anterior',
            'icon' => 'fa-bolt',
            'extraClasses' => ['hide-on-date']
        ])
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="zone-consumption" >
        @include('test.electric.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 1250360,
            'measure' => 'kWh',
            'title' => 'Consumo Pocillas mes actual',
            'icon' => 'fa-industry'
        ])
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-zone-consumption" >
        @include('test.electric.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 2850500,
            'measure' => 'kWh',
            'title' => 'Consumo Pocillas mes anterior',
            'icon' => 'fa-industry',
            'extraClasses' => ['hide-on-date']
        ])
    </div>
</div>
<div class="row mt-4">
    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-12" id="consumption-options-col">
        <div class="form-group">
            <label class="form-label">Seleccione un rango de fechas</label>
            <input type="text" class="form-control consumption-date" name="date_filter" id="date_filter">
        </div>

        @include('test.electric.components.data-box',[
            'bg' => 'bg-success-300',
            'value' => 794328.4,
            'measure' => '###',
            'title' => '####',
        ])
        @include('test.electric.components.data-box',[
           'bg' => 'bg-success-300',
           'value' => 262047.8,
           'measure' => 'KVARH',
           'title' => 'Reactiva',
        ])
        @include('test.electric.components.data-box',[
          'bg' => 'bg-success-300',
          'value' => 855896.2,
          'measure' => 'KVAH',
          'title' => 'Aparente',
        ])
    </div>
    <div class="col-xl-9 col-md-9 col-lg-9 col-sm-12" id="consumptionChartContainer">

    </div>
</div>


