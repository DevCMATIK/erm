@extends('layouts.app')
@section('page-title')
    {{ 'Resumen Energía: '.$zone->name }}
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
                'bg' => 'bg-primary',
                'value' => 1000,
                'unit' => 'kWh',
                'title' => 'Consumo este año',
                'icon' => 'fa-calendar'
            ])
       </div>
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary',
                'value' => 1000,
                'unit' => 'kWh',
                'title' => 'Consumo este mes',
                'icon' => 'fa-calendar'
            ])
       </div>

       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => 150,
                'unit' => 'kWh',
                'title' => 'Consumo Ayer',
                'icon' => 'fa-bolt'
            ])
       </div>

       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           @include('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => 150,
                'unit' => 'kWh',
                'title' => 'Consumo Hoy',
                'icon' => 'fa-bolt'
            ])
       </div>
   </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table m-0 table-bordered table-light table-striped table-dark">
                <thead>
                <tr>
                    <th>Sub Zona</th>
                    <th>Ayer</th>
                    <th>Hoy</th>
                    <th>Este mes</th>
                    <th>Este año</th>
                    <th>2020-01</th>
                    <th>2020-02</th>
                    <th>2020-03</th>
                    <th>2020-04</th>
                    <th>2020-05</th>
                </tr>
                </thead>
            </table>
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

@endsection

