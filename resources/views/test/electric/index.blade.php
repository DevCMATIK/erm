@extends('layouts.app')
@section('page-title')
    Dashboard TEST
@endsection
@section('page-icon','bolt')
@section('page-content')
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
                    @include('test.electric.sections.consumption')
                </div>
            </div>
            <div class="tab-pane fade" id="energy-container" role="tabpanel">
                <div class="card-body">
                    @include('test.electric.sections.energy')
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

        $(document).ready(function(){
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.date-filter').daterangepicker(
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

            $('.consumption-date').daterangepicker(
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
                            $('.hide-on-date').show('slideDown');
                        },400)

                        $('#consumption .box-label').html('Consumo mes actual');
                        $('#zone-consumption .box-label').html('Consumo Pocillas mes actual');
                    } else {
                        $('.hide-on-date').hide();
                        $('.consumption-box').removeClass('col-xl-3 col-lg-3 col-md-3',200).addClass('col-xl-6 col-lg-6 col-md-6',200);
                        $('#consumption .box-label').html('Consumo total');
                        $('#zone-consumption .box-label').html('Pocillas consumo total');
                    }
                    console.log(start.format('YYYY-MM-DD'));
                    console.log(end);
                }
            );
        });


    </script>
@endsection

