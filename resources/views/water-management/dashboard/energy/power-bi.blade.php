@extends('layouts.app-blank')
@section('page-title')
    {{ 'Resumen Energía: '.$zone->name }}
@endsection
@section('page-icon','chart-line')
@section('page-content')
    <div class="alert alert-info">
        Copie la siguiente URL en Power BI
        <h1><strong>https://erm.cmatik.app/zone-resume-table/{{ $zone->id }}</strong></h1>
    </div>
    <div class="row my-4">
        <div class="col-12">
            <table class="table m-0 table-bordered table-light">
                <thead>
                <tr>
                    <th>Sub Zona</th>
                    <th>Hoy</th>
                    <th>Ayer</th>
                    <th>Este mes</th>
                    <th>Este año</th>
                    @foreach($consumptions->map(function($item,$key){
                                return collect($item)->map(function($item,$key){
                                    return collect($item['monthly'])->map(function($item){
                                        return $item['month'];
                                    });
                                });
                            })->collapse()->collapse()->unique() as $month)
                        <th>{{ $month }}</th>
                    @endforeach
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
                        @foreach($consumptions->map(function($item,$key){
                               return collect($item)->map(function($item,$key){
                                   return collect($item['monthly'])->map(function($item){
                                       return $item['month'];
                                   });
                               });
                           })->collapse()->collapse()->unique() as $month)
                            <td><strong>{{ (is_numeric(collect($consumption[key($consumption)]['monthly'])->where('month',$month)->first()['consumption']))?number_format(collect($consumption[key($consumption)]['monthly'])->where('month',$month)->first()['consumption'],1,',','.'):'0'}}</strong> <span class="fs-nano">kWh</span></td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

