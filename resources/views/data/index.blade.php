@extends('layouts.app')
@section('page-title','Data de Dispositivos')
@section('page-icon','database')
@section('page-content')
    @if ($message = \Illuminate\Support\Facades\Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div id="panel-2" class="panel">
        <div class="panel-hdr">
            <h2>
                Dispositivos <span class="fw-300"><i>Status de la data historica</i></span>

            </h2>
            <div class="panel-toolbar">
                <a class="btn btn-primary btn-xs"  href="/syncDevices"><i class="fas fa-sync" ></i> Sincronizar Dispositivos</a>
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>


            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                    Puedes filtrar por sub zona y dispositivo usando subzona-dispositivo ej: coya-copa coya, coya-, copa coya, etc.
                </div>
                <div class="border bg-light rounded-top">
                    <div class="form-group p-2 m-0 rounded-top">
                        <input type="text" class="form-control form-control-lg shadow-inset-2 m-0" id="js_list_accordion_filter" placeholder="Filtrar dispositivos">
                    </div>
                    @php
                        $script = '';
                    @endphp
                    <div id="js_list_accordion" class="accordion accordion-hover accordion-clean">
                        @foreach($devices as $device)
                            @php
                                $deviceCheck = 1;
                            @endphp
                            <div class="card border-top-left-radius-0 border-top-right-radius-0">
                                <div class="card-header ">
                                    <a href="javascript:void(0);"
                                       class="card-title collapsed"
                                       data-toggle="collapse"
                                       data-target="#device_list_{{ $device->id }}"
                                       aria-expanded="false"
                                       data-filter-tags="{{ strtolower($device->name) }} @foreach($device->check_point->sub_zones as $sub_zone){{ strtolower($sub_zone->name.'-'.$device->name.' ') }}@endforeach">
                                        <i class="fal fa-cog width-2 fs-xl"></i>
                                        {{ $device->name }} <div class="ml-3" id="header_{{ $device->id }}"></div>
                                        <span class="ml-auto">
                                            <span class="collapsed-reveal">
                                                <i class="fal fa-chevron-up fs-xl"></i>
                                            </span>
                                            <span class="collapsed-hidden">
                                                <i class="fal fa-chevron-down fs-xl"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <div id="device_list_{{ $device->id }}" class="collapse"  data-parent="#js_list_accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                Click <a href="/backupDevice/{{ $device->id }}" class="btn btn-primary btn-xs">AQUI</a> para comenzar la converson de este dispositvo completo, puedes hacer click en el icono <i class="fas fa-cog mx-2"> </i> de cada mes o sensor para hacerlo aun mas particionado.
                                                <br><br>
                                                @forelse($device->sensors as $sensor)
                                                    @if(optional($sensor->average)->last_average != null)
                                                        <a href="/sensorAveragesBackup/{{ $sensor->id }}" class="btn btn-primary btn-xs m-2">{{ $sensor->full_address }}</a>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                        <ul class="list-group">
                                            @foreach($device->data_checks->groupBy('month')  as $key => $data)

                                                @php

                                                    $monthCheck = 1;
                                                @endphp
                                                <li class="list-group-item cursor-pointer" id="{{$device->id}}_month_{{ $key }}" data-remote="true" href="#collapsed_{{ $key }}" id="parent_{{$device->id}}" data-toggle="collapse" data-parent="#collapsed_{{ $key }}">
                                                    {{  ucfirst(\Carbon\Carbon::createFromFormat('m',$key)->formatLocalized('%B %Y')) }}
                                                    <a href="/backupDeviceByMonth/{{$key}}/{{ $device->id }}" class="float-right"><i class="fas fa-cog"></i></a>
                                                </li>
                                                <ul class="collapse list-group"  id="collapsed_{{$key}}">
                                                    @foreach ($data as $sensor)
                                                        @php

                                                            if($sensor->check == 0) {
                                                                $deviceCheck = 0;
                                                                $monthCheck = 0;
                                                            }
                                                        @endphp
                                                        <li class="list-group-item pl-5">
                                                            <i class="fas fa-circle @if($sensor->check == 0 ) text-danger @else text-success @endif"></i>
                                                            {{ $sensor->address }}
                                                            <a href="/backupDeviceBySensor/{{$key}}/{{ $device->id }}/{{ $sensor->address }}" class="float-right text-dark"><i class="fas fa-cog"></i></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                    @if($monthCheck == 1)
                                                    @php
                                                        $script = $script . "$('#".$device->id."_month_".$key."').prepend('<i class=\"fa fa-circle text-success\"></i>');";
                                                    @endphp
                                                    @else
                                                    @php
                                                        $script = $script . "$('#".$device->id."_month_".$key."').prepend('<i class=\"fa fa-circle text-danger\"></i>');";
                                                    @endphp
                                                    @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                @if($deviceCheck == 1)
                                    @php
                                        $script = $script . "$('#header_".$device->id."').html('<i class=\"fa fa-circle text-success\"></i>');";
                                    @endphp
                                @else
                                    @php
                                        $script = $script . "$('#header_".$device->id."').html('<i class=\"fa fa-circle text-danger\"></i>');";
                                    @endphp
                                @endif
                        @endforeach
                    </div>
                    <span class="filter-message js-filter-message"></span>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-extra-scripts')
    <script>
        initApp.listFilter($('#js_list_accordion'), $('#js_list_accordion_filter'));
        $(document).ready(function(){
            {!! $script !!}
        });
    </script>
@endsection
