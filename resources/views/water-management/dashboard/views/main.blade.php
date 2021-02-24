@extends('layouts.app')
@section('page-content')

    <div class="row ">

        <div class="col-xl-12">
            @include('water-management.dashboard.statistics.small-boxes')

            <div class="row">
                <div class="col-xl-12" id="cupLevelsContainer">
                    @include('water-management.dashboard.statistics.cup-levels',['zones', $zones])
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
    ]) !!}
@endsection
@section('page-extra-scripts')
    <script>
        function redirectToAlarms()
        {
            location.href = "/dashboard-alarms";
        }

        function redirectToOfflineDevices()
        {
            location.href = "/offline-devices";
        }

        function redirectToOfflineDev()
        {
            location.href = "/offline-devices-list";
        }
        getOnlineDevices();
        getAlarmsOn();

        $(document).ready(function(){

           /* $.get('/kpi/getCupLevels', function (data) {
                $('#cupLevelsContainer').html(data);

            });*/
        });

        function getOnlineDevices()
        {
            $.get('/kpi/getOnlineDevices',function(data){
                $('#online-devices').html(data);
            });
        }

        function getAlarmsOn()
        {
            $.get('/kpi/getAlarmsOn',function(data){
                $('#alarms-on').html(data);
            });
        }


    </script>
@endsection
