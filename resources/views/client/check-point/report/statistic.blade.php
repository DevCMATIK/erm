@extends('layouts.app')
@section('page-title','Status reportes DGA : '.$check_point->name.' - '.$check_point->work_code)
@section('page-icon','check')
@section('more-css')
    <link rel="stylesheet" href="{{ asset('/plugins/step-form-wizard/css/step-form-wizard-all.css') }}">

    <style>

        fieldset legend {
            text-align: center;
            margin-bottom: 50px !important;
        }
        fieldset {
            overflow: hidden;
            padding-bottom: 70px !important;
        }
        .day-box {
            display: inline-block;
            width: 14%;
            border: 1px solid #4c5965;
            padding: 30px;
            padding-bottom: 10px !important;
            margin-bottom: 4px;
            text-align: center;
        }
    </style>
@endsection
@section('more-scripts')
    <script src="{{ asset('/plugins/step-form-wizard/js/step-form-wizard.min.js') }}"></script>
    <script>
        sfw = $("#statistics-form").stepFormWizard({
            height: 'first',
            theme: 'sky' ,// sea, sky, simple, circle, sun,
            nextBtn : $('<a class="next-btn sf-right sf-btn bg-primary text-white" href="#">Siguiente</a>'),
            prevBtn : $('<a class="prev-btn sf-left sf-btn bg-primary text-white" href="#">Anterior</a>'),
            finishBtn : $(''),
            showNav : true,
            showButtons : false,
            transition : 'slide',

            onNext: function() {

            },
            onFinish: function() {

            }
        });
    </script>
@endsection
@section('page-description')
@endsection
@section('page-content')
    <div class="row">
        <div class="col-xl-12">
            <form id="statistics-form">
                @php
                    if($check_point->dga_report == 1) {
                        $max = 24;
                    } else {
                        $max = 1;
                    }
                @endphp
                @foreach($reports as $month => $reps)
                    <fieldset>
                        <legend>{{ $month }}</legend>
                        @php
                            $last_day = \Carbon\Carbon::parse($month.'-01')->endOfMonth()->day;
                        @endphp
                        @for($i = 1 ; $i<=$last_day ; $i++)
                            @php
                                $rep = $reps->where('date',$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT))->first()
                            @endphp
                            @if($rep)
                                <div class="day-box text-white @if($rep['reports'] >= $max) bg-success @else @if($month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT) == now()->toDateString()) bg-info @else bg-danger @endif @endif">
                                    <div class="label-day-box" style="float:left; margin-top: -20px; margin-left: -20px; font-size: 1.5em;">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="label-day-box" style="float:right; margin-bottom: -10px; margin-right: -20px; font-size: 1.5em; font-weight: bolder;">
                                        {{ ($rep['reports'] > $max)? $max.' / '.$max :$rep['reports'] .' / '.$max }}
                                    </div>
                                </div>
                            @else
                                <div class="day-box text-white bg-secondary">
                                    <div class="label-day-box" style="float:left; margin-top: -20px; margin-left: -20px; font-size: 1.5em;">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="label-day-box" style="float:right; margin-bottom: -10px; margin-right: -20px; font-size: 1.5em; font-weight: bolder;">
                                         n/r
                                    </div>
                                </div>
                            @endif

                        @endfor
                    </fieldset>
                @endforeach


            </form>

        </div>
    </div>


@endsection

