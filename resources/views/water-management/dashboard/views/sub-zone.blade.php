@extends('layouts.app')
@section('page-title')
    {{ 'Dashboard : '.$subZone->name }} <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
@endsection
@section('page-icon','chart-bar')
@section('page-content')

    <nav class="shortcut-menu  d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        @if(count($check_point_kpis ) > 0)
            <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-kpi" class="menu-item btn"  data-placement="left" title="Ver Kpi">
                <i class="fal fa-chart-pie"></i>
            </a>
        @endif
        <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
            <i class="fal fa-arrow-up"></i>
        </a>
    </nav>

    <style>
        .progress-bar-vertical {
            width: 80%;
            margin: auto;
            min-height: 140px;
            display: flex;
            align-items: flex-end;
            border-radius: 5px !important;
        }

        .progress-bar-vertical .progress-bar {
            width: 100%;
            height: 0;
            -webkit-transition: height 0.6s ease;
            -o-transition: height 0.6s ease;
            transition: height 0.6s ease;
        }
        @if(Sentinel::getUser()->hasAccess('dashboard.control-mode'))

            @include('water-management.dashboard.partials.output-css')

        @endif
    </style>

    <div class="row" id="dashboard-content">

    </div>
    @if(count($check_point_kpis ) > 0)
    <div class="modal fade js-modal-kpi" tabindex="-1" role="dialog" id="modal-kpi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right modal-md">
            <div class="modal-content h-100">
                <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                    <h4 class="text-white">KPI</h4>
                    <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body  h-100  p-4" id="kpi-container">
                    @foreach($check_point_kpis as $kpi)
                        <div class="row mb-4">
                            @include('water-management.dashboard.partials.kpi.cost-kpi')
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('more-scripts')
    {!! includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]) !!}
@endsection
@section('page-extra-scripts')
    <script>
        $('.btn-alarm').hide();
        Highcharts.setOptions({
            global: {
                useUTC: false
            },
            lang: {
                decimalPoint: ',',
                thousandsSep: ''
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
           $.get('/getDashboardContent/{{ $subZone->id }}',function(data){
               $('#dashboard-content').html(data);
           });
       }
        setInterval(function(){
           getDashboardContent();
        },10000);


    </script>
@endsection

