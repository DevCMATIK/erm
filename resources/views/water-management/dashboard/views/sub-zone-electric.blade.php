@extends('layouts.app')
@section('page-title')
    {{ 'Dashboard : '.$subZone->name }} <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
@endsection
@section('page-icon','bolt')
@section('page-content')
    {!! includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css') !!}
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

@endsection
@section('more-scripts')
    {!! includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]) !!}
@endsection
@section('page-extra-scripts')
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}
    @include('water-management.dashboard.views.electric.charts.energy-chart')
    @include('water-management.dashboard.views.electric.charts.tension-chart')
    @include('water-management.dashboard.views.electric.charts.stream-chart')
    @include('water-management.dashboard.views.electric.charts.power-chart')
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
            $.get('/getDashboardContentElectric/{{ $subZone->id }}',function(data){
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
@endsection

