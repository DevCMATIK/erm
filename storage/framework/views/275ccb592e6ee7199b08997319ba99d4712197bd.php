<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="consumption" >
        <?php echo $__env->make('test.electric.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 85423,
            'measure' => 'kWh',
            'title' => 'Consumo mes actual',
            'icon' => 'fa-calendar'
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-consumption" >
        <?php echo $__env->make('test.electric.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 85122,
            'measure' => 'kWh',
            'title' => 'Consumo Mes anterior',
            'icon' => 'fa-bolt',
            'extraClasses' => ['hide-on-date']
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="zone-consumption" >
        <?php echo $__env->make('test.electric.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 1250360,
            'measure' => 'kWh',
            'title' => 'Consumo Pocillas mes actual',
            'icon' => 'fa-industry'
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-zone-consumption" >
        <?php echo $__env->make('test.electric.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 2850500,
            'measure' => 'kWh',
            'title' => 'Consumo Pocillas mes anterior',
            'icon' => 'fa-industry',
            'extraClasses' => ['hide-on-date']
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-12" id="consumption-options-col">
        <div class="form-group">
            <label class="form-label">Seleccione un rango de fechas</label>
            <input type="text" class="form-control consumption-date" name="date_filter" id="date_filter">
        </div>

        <?php echo $__env->make('test.electric.components.data-box',[
            'bg' => 'bg-success-300',
            'value' => 794328.4,
            'measure' => '###',
            'title' => '####',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
           'bg' => 'bg-success-300',
           'value' => 262047.8,
           'measure' => 'KVARH',
           'title' => 'Reactiva',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-success-300',
          'value' => 855896.2,
          'measure' => 'KVAH',
          'title' => 'Aparente',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-xl-9 col-md-9 col-lg-9 col-sm-12" id="consumptionChartContainer">

    </div>
</div>


<?php /**PATH /shared/httpd/erm/resources/views/test/electric/sections/consumption.blade.php ENDPATH**/ ?>