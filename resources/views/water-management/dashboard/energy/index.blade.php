@extends('layouts.app')
@section('page-title')
    {{ 'Dashboard : '.$subZone->name }} <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
@endsection
@section('page-icon','bolt')
@section('page-content')
    <input type="hidden" id="sub_zone" value="{{ $subZone->id }}">
    <input type="hidden" id="zone" value="{{ $subZone->zone_id }}">
    {!! includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css') !!}
    <style>
        @media (max-width: 576px) {
            .main-box-number {
                font-size: 1.3em;
            }
            .box-label {
                font-size: 0.7em;
            }
            .main-box-icon {
                visibility: hidden;
            }
        }
    </style>
    <div class="card border">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#consumption-container">Consumo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#energy-container">Energía</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="consumption-container" role="tabpanel">
                <div class="card-body">
                    @include('water-management.dashboard.energy.sections.consumption')
                </div>
            </div>
            <div class="tab-pane fade" id="energy-container" role="tabpanel">
                <div class="card-body">
                    @include('water-management.dashboard.energy.sections.energy')
                </div>
            </div>
        </div>
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
    <script>
        $('.btn-alarm').hide();
        function getConsumption(start = false, end = false,container = 'consumption') {
            let start_date,end_date;
            if(start != false) {
                start_date = start;
            } else {
                start_date = moment().startOf('month').format('YYYY-MM-DD');
            }

            if(end != false) {
                end_date = end;
            } else {
                end_date = moment().endOf('month').format('YYYY-MM-DD');
            }


            $.ajax({
                url     : '/energy/get-consumption-data',
                type    : 'GET',
                data    : {
                    sub_zone : $('#sub_zone').val(),
                    start_date : start_date,
                    end_date : end_date,
                },
                success : function ( data )
                {
                    $('#'+container).html(data);
                },
                error   : function ( response )
                {
                    console.log(response);
                }
            });
        }

        function getZoneConsumption(start = false, end = false,container = 'zone-consumption') {
            let start_date,end_date;
            if(start != false) {
                start_date = start;
            } else {
                start_date = moment().startOf('month').format('YYYY-MM-DD');
            }

            if(end != false) {
                end_date = end;
            } else {
                end_date = moment().endOf('month').format('YYYY-MM-DD');
            }

            $.ajax({
                url     : '/energy/get-zone-consumption-data',
                type    : 'GET',
                data    : {
                    zone : $('#zone').val(),
                    start_date : start_date,
                    end_date : end_date,
                },
                success : function ( data )
                {
                    $('#'+container).html(data);
                },
                error   : function ( response )
                {
                    console.log(response);
                }
            });
        }

        getConsumption();
        getConsumption(moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD'),'last-month-consumption');
        getZoneConsumption();
        getZoneConsumption(moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD'),'last-month-zone-consumption');

        $(document).ready(function(){
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.date-filter').daterangepicker(
                {
                    opens: 'right',
                    templates: controls,
                    maxDate : moment(),
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

            $('.consumption-date').daterangepicker(
                {
                    opens: 'right',
                    templates: controls,
                    maxDate : moment(),
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
                    startDate : moment().startOf('month'),
                    endDate: moment().endOf('month'),
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
                    if(moment().startOf('month').isSame(start) && moment().endOf('month').isSame(end)) {
                        $('.consumption-box').removeClass('col-xl-6 col-lg-6 col-md-6',200).addClass('col-xl-3 col-lg-3 col-md-3',200);
                        setTimeout(function(){
                            $('#last-month-consumption').show('slideDown');
                            $('#last-month-zone-consumption').show('slideDown');
                        },400);

                        $('#consumption .box-label').html('Consumo mes actual');
                        $('#zone-consumption .box-label').html('Consumo Pocillas mes actual');
                    } else {
                        $('#last-month-consumption').hide();
                        $('#last-month-zone-consumption').hide();
                        $('.consumption-box').removeClass('col-xl-3 col-lg-3 col-md-3',200).addClass('col-xl-6 col-lg-6 col-md-6',200);
                        $('#consumption .box-label').html('Consumo total');
                        $('#zone-consumption .box-label').html('Pocillas consumo total');
                    }
                    getConsumption(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                    getZoneConsumption(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                }
            );


        });

        Highcharts.chart('consumptionChartContainer', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'World\'s largest cities per 2017'
            },
            subtitle: {
                text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Population (millions)'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    ['Shanghai', 24.2],
                    ['Beijing', 20.8],
                    ['Karachi', 14.9],
                    ['Shenzhen', 13.7],
                    ['Guangzhou', 13.1],
                    ['Istanbul', 12.7],
                    ['Mumbai', 12.4],
                    ['Moscow', 12.2],
                    ['São Paulo', 12.0],
                    ['Delhi', 11.7],
                    ['Kinshasa', 11.5],
                    ['Tianjin', 11.2],
                    ['Lahore', 11.1],
                    ['Jakarta', 10.6],
                    ['Dongguan', 10.6],
                    ['Lagos', 10.6],
                    ['Bengaluru', 10.3],
                    ['Seoul', 9.8],
                    ['Foshan', 9.3],
                    ['Tokyo', 9.3]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });

        Highcharts.chart('powerChartContainer', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });

        Highcharts.chart('tensionChartContainer', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });

        Highcharts.chart('streamChartContainer', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });
    </script>
@endsection

