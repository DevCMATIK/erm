<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="consumption" onclick="downloadConsumptions();">
        <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 0,
            'unit' => 'kWh',
            'title' => 'Consumo mes actual',
            'icon' => 'fa-calendar'
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-consumption" onclick="downloadConsumptions();" >
        <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 0,
            'unit' => 'kWh',
            'title' => 'Consumo Mes anterior',
            'icon' => 'fa-bolt',
            'extraClasses' => ['hide-on-date']
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer consumption-box mb-1" id="zone-consumption" onclick="downloadConsumptions();" >
        <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
            'bg' => 'bg-primary',
            'value' => 0,
            'unit' => 'kWh',
            'title' => 'Consumo Pocillas mes actual',
            'icon' => 'fa-industry'
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 cursor-pointer mb-1" id="last-month-zone-consumption"  onclick="downloadConsumptions();">
        <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
            'bg' => 'bg-primary-300',
            'value' => 0,
            'unit' => 'kWh',
            'title' => 'Consumo Pocillas mes anterior',
            'icon' => 'fa-industry',
            'extraClasses' => ['hide-on-date']
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-12">
        <div class="form-group">
            <label class="form-label">Seleccione un rango de fechas</label>
            <input type="text" class="form-control consumption-date" name="date_filter" id="consumption-filter">
        </div>
        <div id="ee-e-activa-container">
            <?php echo $__env->make('water-management.dashboard.energy.components.data-box',[
               'bg' => 'bg-success-300',
               'value' => 0,
               'unit' => '###',
               'title' => '######',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div id="ee-e-reactiva-container">
            <?php echo $__env->make('water-management.dashboard.energy.components.data-box',[
                  'bg' => 'bg-success-300',
                  'value' => 0,
                  'unit' => '###',
                  'title' => '######',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div id="ee-e-aparente-container">
            <?php echo $__env->make('water-management.dashboard.energy.components.data-box',[
                'bg' => 'bg-success-300',
                'value' => 0,
                'unit' => '###',
                'title' => '######',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="col-xl-9 col-md-9 col-lg-9 col-sm-12" id="consumptionChartContainer">

    </div>
</div>



<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/energy/sections/consumption.blade.php ENDPATH**/ ?>