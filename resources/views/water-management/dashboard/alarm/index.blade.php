@extends('layouts.app')
@section('page-title','Control de Alarmas')
@section('page-icon','exclamation-triangle')
@section('page-content')
    <div class="row ">
        <div class="col-xl-12">
            @include('water-management.dashboard.alarm.boxes')
            <div class="row">
                <div class="col-xl-12">
                    <div id="panel-alarms-table" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                Alarmas Activas
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            </div>
                        </div>
                        <div class="panel-container show ">
                            <div class="panel-content table-responsive p-0" id="active-alarms-table">

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div id="panel-last-alarms-table" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                Ultimas 50 Alarmas
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            </div>
                        </div>
                        <div class="panel-container show ">
                            <div class="panel-content table-responsive p-0" id="last-alarms-table">

                            </div>
                        </div>
                    </div>

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


        $(document).ready(function(){
            getAlarmsTotal();
            getAlarmsOn();
            getLastAlarm();
            getActiveAlarmsTable();
            getLastAlarmsTable();



        });

        function getAlarmsTotal()
        {
            $.get('/kpi/getAlarmsTotal',function(data){
                $('#alarms-total').html(data);
            });
        }

        function getAlarmsOn()
        {
            $.get('/kpi/getAlarmsOn',function(data){
                $('#alarms-on').html(data);
            });
        }

        function getLastAlarm()
        {
            $.get('/kpi/getLastAlarm',function(data){
                $('#last-alarm').html(data);
            });
        }

        function getActiveAlarmsTable()
        {
            $.get('/dashboard-alarms/getActiveAlarmsTable',function(data){
                $('#active-alarms-table').html(data);
            });
        }

        function getLastAlarmsTable()
        {
            $.get('/dashboard-alarms/getLastAlarmsTable',function(data){
                $('#last-alarms-table').html(data);
            });
        }
    </script>
@endsection
