@extends('layouts.app')
@section('page-title')
    {{ 'Resumen Energía: '.$zone->name }}
    <a href="/zone-resume-table/{{ $zone->id }}" class="btn btn-primary btn-xs pull-right" target="_blank">Vista PowerBI</a>
@endsection
@section('page-icon','bolt')
@section('page-content')
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
   <div class="row">
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + (is_numeric($item[key($item)]['today'])?$item[key($item)]['today']:0);
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo Hoy',
                'icon' => 'fa-bolt'
            ])
       </div>
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['yesterday'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo Ayer',
                'icon' => 'fa-bolt'
            ])
       </div>

       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['this-month']['consumption'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo este mes',
                'icon' => 'fa-calendar'
            ])
       </div>
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['this-year']['consumption'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo este año',
                'icon' => 'fa-calendar'
            ])
       </div>
   </div>
    <div class="row my-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills justify-content-end" role="tablist">
                        <li class="nav-item">
                            <div class="form-group mr-3">
                                <select name="sub_zone_id" id="sub_zone_id" class="form-control">
                                    <option value="">Todas las Sub zonas</option>
                                    @foreach($sub_zones as $sub_zone)
                                        <option value="{{ $sub_zone }}">{{ $sub_zone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="nav-item" id="sensor_list_dropdown">
                            <a class="form-control border " href="javascript:void(0);" data-toggle="dropdown">Meses <i class="fal fa-chevron-down"></i></a>
                            <ul class="dropdown-menu " style="max-height: 300px; overflow-y: auto;">
                                @foreach(array_reverse($years->toArray()) as $year)
                                    <li class="list-group-item">
                                        <label class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" id="check_{{$year}}" class="custom-control-input sensors year-check" value="{{ $year }}" checked name="years">
                                            <span class="custom-control-label">{{ $year }}</span>
                                        </label>
                                        @php
                                            \Carbon\Carbon::setLocale('es');
                                            setlocale(LC_ALL, 'es_ES');
                                        @endphp
                                        @foreach($months as $month)

                                            @if(stristr($month,$year))
                                                <label class="custom-control custom-checkbox ml-4">
                                                    <input type="checkbox" class="custom-control-input sensors check_{{ $year }}" value="{{ $month }}" checked name="months">
                                                    <span class="custom-control-label">{{ \Carbon\Carbon::parse($month.'-01')->formatLocalized('%B')  }}</span>
                                                </label>
                                            @endif
                                        @endforeach
                                    </li>
                                @endforeach

                            </ul>
                        </li>


                    </ul>

                    <div class="row">
                        <div class="col" id="chartContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <table class="table m-0 table-bordered table-light table-striped table-dark">
                <thead>
                <tr>
                    <th>Sub Zona</th>
                    <th>Hoy</th>
                    <th>Ayer</th>
                    <th>Este mes</th>
                    <th>Este año</th>

                </tr>
                </thead>
                <tbody>
                    @foreach($consumptions as $consumption)
                        <tr>
                            <td>{{ key($consumption) }}</td>
                            <td><strong>{{ (is_numeric($consumption[key($consumption)]['today']))?number_format($consumption[key($consumption)]['today'],1,',','.'):'0'}}</strong> <span class="fs-nano">kWh</span></td>
                            <td><strong>{{ (is_numeric($consumption[key($consumption)]['yesterday']))?number_format($consumption[key($consumption)]['yesterday'],1,',','.'):'0'}}</strong> <span class="fs-nano">kWh</span></td>
                            <td><strong>{{ (is_numeric($consumption[key($consumption)]['this-month']['consumption']))?number_format($consumption[key($consumption)]['this-month']['consumption'],1,',','.'):'0'}}</strong> <span class="fs-nano">kWh</span></td>
                            <td><strong>{{ (is_numeric($consumption[key($consumption)]['this-year']['consumption']))?number_format($consumption[key($consumption)]['this-year']['consumption'],1,',','.'):'0'}}</strong> <span class="fs-nano">kWh</span></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('more-scripts')
    {!! includeScript([
         'plugins/highcharts/highcharts.js',
         'plugins/highcharts/modules/exporting.js',
     ]) !!}
    @include('water-management.dashboard.energy.chart.chart', ['zone_id' => $zone->id])

    <script>
        function getFilters()
        {
            return {
                months : $.map($('input[name="months"]:checked'), function(c){return c.value; }),
                sub_zone : $('#sub_zone_id').val()
            };
        }
        $('.year-check').on('click',function() {
            let year = $(this).val();
            $('.check_'+year).prop('checked',$(this).is(':checked'));
            renderChart()
        });

        $('#sub_zone_id').on('change',function() {
            renderChart();
        })

        $('input[name="months"]').on('click',function() {
            let year = $(this).val().split('-')[0];
            let checks = document.querySelectorAll('.check_'+year)
            let allChecked = true;

            for (let i = 0; i < checks.length; i++) {
                if(!checks[i].checked) {
                    allChecked = false;
                }
            }
            $('#check_'+year).prop('checked',allChecked)
            renderChart();

        });
        renderChart();
    </script>
@endsection
@section('page-extra-scripts')
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}

@endsection

