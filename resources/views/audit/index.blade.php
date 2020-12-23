@extends('layouts.app')

@section('page-content')
@inject('users', App\Services\ListBox)
@inject('events', App\Services\ListBox)

<!--BOX Filters -->
    <div class="row">
        <div class="col-12">
            <div id="panel-alarms-table" class="panel">
                <nav class="col-md-12 navbar navbar-light bg-light align-content-center">
                    <a class="navbar-brand">Busqueda Avanzada</a>
                    @csrf
                    <form class=" col-12 my-sm-8">
                        <div class="row my-2">
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Seleccione un rango de fechas</label>
                                    <input type="text"  class="form-control datepicker" id="date" name="dates">
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Usuarios -->
                                    <label class="form-label">Filtro por Usuarios</label>
                                    <select id="user_id" name="user[]" multiple
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            class="form-control text-dark selectpicker">
                                        @foreach($users->getUsers() as $index => $user)
                                            <option value="{{ $index }}" {{ (collect()->contains($index)) ? 'selected' : '' }}>
                                                {{ $user }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('user_id') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Tipos de Sensor -->
                                    <label class="form-label">Tipo de evento</label>
                                    <select id="type_sensor_id" name="type_sensor[]"
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            multiple class="form-control selectpicker {{ $errors->has('type_sensor_id') ? ' is-invalid' : '' }}" >
                                        @foreach($events->getEventType() as $index => $event)
                                            <option value="{{ $index }}" {{ old('type_sensor_id') == $index ? 'selected' : '' }}>
                                                {{ $event }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_sensor_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type_sensor_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-4">
                                <button id="applyFilters" class="btn btn-success col-12 mr-sm-3 my-2 pull-right" type="submit">Aplicar Filtros</button>
                            </div>
                        </div>
                    </form>
                </nav>
            </div>
        </div>
    </div>

<!--CRUD Ultimas 50 cambios -->
    <div class="row">
    <div class="col-xl-12">
        <div id="panel-last-alarms-table" class="panel">
            <div class="panel-hdr">
                <h2>Ultimos 50 Cambios</h2>
                <div class="panel-toolbar">
                    <button class="btn btn-outline-success btn-sm" id="download-last-alarm"><i class="fas fa-file-excel"></i> Excel </button>
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show " id="contenido">
                <div class="panel-content table-responsive p-0" id="log-table"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('more-scripts')
    {!! includeScript([
        'plugins/highcharts/highcharts.js',
        'plugins/highcharts/modules/boost.js',
        'plugins/highcharts/modules/exporting.js',
        'plugins/selectpicker/js/bootstrap-select.min.js'
    ]) !!}
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}
@endsection

@section('select-scripts')
    <script>
        $(document).ready(function (){
            function loadSubzone(){
                var zone_id= $('#zone_id').val();
                if($.trim(zone_id) !=''){
                    $.get('getSubZones', {zone_id: zone_id}, function (subzones){
                        removeItems('sub_zone_id');
                        $.each(subzones, function (index,value){
                            $('#sub_zone_id').append("<option value='"+ index + "'>" + value + "</option>")
                        });
                        $('#sub_zone_id').selectpicker('refresh');
                    });
                }
            }
            $('#zone_id').on('change', loadSubzone);
        });

        function removeItems(select) {
            $('#'+select+' option').each(function(index,element){
                element.remove();
            });

            $('#'+select).selectpicker('refresh');
        }
    </script>
@endsection

@section('page-extra-scripts')
    <script>

        $('#download-last-alarm').click
        (function(e){
                toastr.info("Se esta generando un Excel")
                location.href="/exportLastAlarm"
            }
        );

        initApp.listFilter($('#js_list_accordion_sub_zones'), $('#js_list_accordion_filter_sub_zones'));
        $(document).ready(function(){
            $('.selectpicker').selectpicker('refresh');
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.datepicker').daterangepicker(
                {
                    opens: 'right',
                    "parentEl": "body",
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
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' +  + ')');
                });
        });

        $(document).ready(function(){
            getLastAlarmsTable();
        });

        function getLastAlarmsTable()
        {
            $.get('/audit/getLogTable',function(data){
                $('#log-table').html(data);
            });
        }
    </script>
@endsection

@section('more-css')
    {!! includeCss([
        'plugins/bootstrap-daterangepicker/daterangepicker.css',
        'plugins/selectpicker/css/bootstrap-select.min.css'
    ]) !!}

    <style>
        .fix-selectpicker  .dropdown-menu.show {
            transform: scale(1) !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>

@endsection
