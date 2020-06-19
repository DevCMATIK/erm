@extends('layouts.app')
@section('page-title')
    <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-messenger"><i class='subheader-icon fas fa-chart-line'></i>

    {{ $subZone->name .': '.\App\Domain\Client\CheckPoint\CheckPoint::find($check_point )->name }}</a>
    <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
@endsection
@section('more-scripts')
    {!! includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/boost.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]) !!}
@endsection
@section('page-content')
    <nav class="shortcut-menu  d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-messenger" class="menu-item btn"  data-placement="left" title="Ver puntos de Control">
            <i class="fal fa-bars"></i>
        </a>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-kpi" class="menu-item btn"  data-placement="left" title="Ver Kpi">
            <i class="fal fa-chart-pie"></i>
        </a>
        <a href="/dashboard/{{ $subZone->id }}"  class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Volver al Dashboard">
            <i class="fal fa-chart-line"></i>
        </a>
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
        @include('water-management.dashboard.partials.output-css')
    </style>
    @php
        $options = false;
    @endphp
    @include('water-management.dashboard.partials.navigation')
    <div class="row" id="device-content">

    </div>
    @if($indicators)
        @foreach($indicators as $groupName => $group)
            <div class="row">
                <div class="col-xl-12">
                    <div class="card my-2">
                        <div class="card-body">
                            <h5>{{ $groupName }}</h5>
                            <div class="row">
                                @foreach($group as $item)
                                    <div class="col-xl-3">
                                        <div class="px-2 py-1 bg-primary  rounded overflow-hidden position-relative text-white mb-1 text-center "  >
                                            <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                                    <span class="text-white"  id="" >
                                                        <span class="hidden-md-down" style="font-size: 0.7em !important;">{{ $item['value'] }}</span>
                                                        <span class="hidden-lg-up">{{ $item['value'] }}</span>
                                                        <span class="fs-nano">
                                                        {{ $item['suffix'] }}
                                                        </span>
                                                    </span>
                                            <small class="m-0 l-h-n font-weight-bolder fs-nano">{{ $item['name'].' - '. $item['frame'] }}</small>
                                        </h3>
                                    </div>
                                        </div></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach;
    @endif
@endsection
@section('page-extra-scripts')

    <script>
        $('.btn-alarm').hide();
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        getDeviceContent();
        $(document).ready(function(){
            getAllKpi();

            function getAllKpi()
            {

            }



            function getTotalizerKpi()
            {
                $.get('/getTotalizerKpi/{{ $check_point }}',function(data){
                    $('#kpi-totalizer-content').html(data);
                });
            }
        });




        function activeAndNotAccused(device)
        {
            $('.btn-alarm').show();
            $.get('/setAlarmAccused/'+device);
        }

        function getDeviceContent()
        {
            $.get('/getDeviceContent/{{ $check_point }}',function(data){
                $('#device-content').html(data);
            });
        }





        setInterval(function(){
            getDeviceContent();
        },10000);


    </script>
@endsection
