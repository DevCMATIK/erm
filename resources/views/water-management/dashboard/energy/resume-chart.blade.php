@extends('layouts.app-blank')
@section('page-title')
    Resumen Energía
@endsection
@section('page-icon','bolt')
@section('page-content')
    <div class="row">
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
                                @foreach($months as $month)
                                    <li class="list-group-item">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input sensors" value="{{ $month }}" checked name="months">
                                            <span class="custom-control-label">{{ $month}}</span>
                                        </label>
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

        $('#sub_zone_id').on('change',function() {
            renderChart();
        })

        $('input[name="months"]').on('click',function() {
            renderChart();
        });
        renderChart();
    </script>
@endsection
@section('page-extra-scripts')
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}

@endsection

