@extends('layouts.app')
@section('page-title')
    {{ 'Dashboard : '.$subZone->name }}

    {!! makeLink('/dashboard/'.$subZone->id,'Dashboard','fa-chart-bar','btn-primary float-right') !!}
@endsection
@section('page-icon','chart-bar')
@section('page-content')
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

    <div class="row" id="control-content">


    </div>

@endsection
@section('page-extra-scripts')
    <script>
        getControlContent();


        function activeAndNotAccused(device)
        {
            $.get('/setAlarmAccused/'+device);
        }

        function getControlContent()
        {
            $.get('/getControlContent/{{ $subZone->id }}',function(data){
                $('#control-content').html(data);
            });
        }
        setInterval(function(){
            getControlContent();
        },10000);

    </script>
@endsection

