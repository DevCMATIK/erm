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
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['this-year']['consumption'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo este año',
                'icon' => 'fa-calendar'
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
                'bg' => 'bg-primary-300',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + (is_numeric($item[key($item)]['today'])?$item[key($item)]['today']:0);
                           }),
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
                            <td>{{ $consumption[key($consumption)]['today'] }} kWh</td>
                            <td>{{ $consumption[key($consumption)]['yesterday'] }} kWh</td>
                            <td>{{ $consumption[key($consumption)]['this-month']['consumption'] }} kWh</td>
                            <td>{{ $consumption[key($consumption)]['this-year']['consumption'] }} kWh</td>

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
@endsection
@section('page-extra-scripts')
    {!! includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js') !!}

@endsection

