<?php $__env->startSection('page-title'); ?>
    <?php echo e('Dashboard : '.$subZone->name); ?> <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','bolt'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label class="form-label">Seleccione un rango de fechas</label>
                <input type="text" class="form-control datepicker" id="date" onchange="filterGraphs();">
            </div>
        </div>

    </div>
    <div  id="dashboard-content">

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>

    <?php echo $__env->make('water-management.dashboard.views.electric.charts.energy-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('water-management.dashboard.views.electric.charts.tension-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('water-management.dashboard.views.electric.charts.stream-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('water-management.dashboard.views.electric.charts.power-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        $('.btn-alarm').hide();
        function filterGraphs()
        {

            getTensionChartContainer();
            getStreamChartContainer();
            getPowerChartContainer();
        }
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });

         getDashboardContent();

        function activeAndNotAccused(device)
        {
            $('.btn-alarm').show();
            $.get('/setAlarmAccused/'+device);
        }
        function getDashboardContent()
        {
            $.get('/getDashboardContentElectric/<?php echo e($subZone->id); ?>',function(data){
                $('#dashboard-content').html(data);
            });
        }
        setInterval(function(){
            //getDashboardContent();
        },10000);

        $(document).ready(function(){
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.datepicker').daterangepicker(
                {
                    opens: 'right',
                    templates: controls,
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    "showDropdowns": true,
                    "showWeekNumbers": true,
                    "showISOWeekNumbers": true,
                    "timePicker": false,
                    "timePicker24Hour": false,
                    "timePickerSeconds": false,
                    "autoApply": false,
                    ranges:
                        {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                            'Esta Semana': [moment().startOf('week'), moment().endOf('week')],
                            'Semana Pasada': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label)
                {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
        });

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/sub-zone-electric.blade.php ENDPATH**/ ?>