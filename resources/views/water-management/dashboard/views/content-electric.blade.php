@php
$types = $subZone->elements->map(function($element){
    return $element->sub_elements->map(function($sub_element){
        return $sub_element->analogous_sensors->map(function($item){
            return $item;
        });
    });
})->collapse()->collapse()->groupBy('sensor.type.slug')->map(function($item,$key){
    return $item->groupBy('sensor.name');
});


@endphp
<div class="row my-4">
    <div class="col-xl-12">
        <div class="row ">
            <div class="col-xl-2 cursor-pointer" onclick="downloadConsumptions();">
                <div class="px-2 py-1 bg-primary has-popover rounded overflow-hidden position-relative text-white mb-1 text-center "   data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="{{ number_format($this_month_sub_zone,2,',','.') }} kWh" data-original-title="Consumo Mes Actual" >
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500"  >
                                <span class="text-white"  id="" >
                                    <span class="hidden-lg-up" > {{ number_format($this_month_sub_zone,2,',','.') }}</span>
                                    <span class="hidden-md-down" style="font-size: 0.7em !important;">{{ shortBigNumbers($this_month_sub_zone) }}</span>
                                    <span class="fs-nano">
                                    kWh
                                    </span>
                                </span>
                            <small class="m-0 l-h-n font-weight-bolder fs-nano">Consumo Mes Actual</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 cursor-pointer" onclick="downloadConsumptions();">
                <div class="px-2 py-1 bg-primary has-popover rounded overflow-hidden position-relative text-white mb-1 text-center " data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="{{ number_format($last_month_sub_zone,2,',','.') }} kWh" data-original-title="Consumo Mes Anterior" >
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <span class="hidden-md-down" style="font-size: 0.7em !important;">{{ shortBigNumbers($last_month_sub_zone) }}</span>
                                    <span class="hidden-lg-up">{{ number_format($last_month_sub_zone,2,',','.') }}</span>
                                    <span class="fs-nano">
                                    kWh
                                    </span>
                                </span>
                            <small class="m-0 l-h-n font-weight-bolder fs-nano">Consumo  Mes Anterior</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 cursor-pointer" onclick="downloadConsumptions();">
                <div class="px-2 py-1 bg-info has-popover rounded overflow-hidden position-relative text-white mb-1 text-center " data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="{{ number_format($this_month_consumption,2,',','.') }} kWh" data-original-title="Consumo {{ $subZone->zone->name }} Mes Actual" >
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white "  id="" >
                                    <span class="hidden-md-down" style="font-size: 0.7em !important;"> {{ shortBigNumbers($this_month_consumption) }}</span>
                                    <span class="hidden-lg-up"> {{ number_format($this_month_consumption,2,',','.') }}</span>

                                    <span class="fs-nano ">
                                    kWh
                                    </span>
                                </span>
                            <small class="m-0 l-h-n font-weight-bolder fs-nano">Consumo {{ $subZone->zone->name }} Mes Actual</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 cursor-pointer" onclick="downloadConsumptions();" >
                <div class="px-2 py-1 bg-info has-popover rounded overflow-hidden position-relative text-white mb-1 text-center " data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="{{ number_format($last_month_consumption,2,',','.') }} kWh" data-original-title="Consumo {{ $subZone->zone->name }} Mes Anterior"  >
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <span class="hidden-md-down" style="font-size: 0.7em !important;"> {{ shortBigNumbers($last_month_consumption) }}</span>
                                    <span class="hidden-lg-up"> {{ number_format($last_month_consumption,2,',','.') }}</span>
                                    <span class="fs-nano">
                                    kWh
                                    </span>
                                </span>
                            <small class="m-0 l-h-n font-weight-bolder fs-nano">Consumo {{ $subZone->zone->name }} Mes Anterior</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                @foreach($types as $key => $type)
                    @if($key == 'ee-frecuencia' )
                        @foreach($type as $analogous)
                            @php
                                $value = array();

                               foreach($analogous as $analogous_sensor) {
                                   if(isset($analogous_sensor)) {
                                    $address = $analogous_sensor->sensor->full_address;
                               if(!$disposition = $analogous_sensor->sensor->dispositions()->where('id',$analogous_sensor->sensor->default_disposition)->first()){
                                   $disposition = $analogous_sensor->sensor->dispositions()->first();
                               }
                               if($disposition) {

                                   $valorReport = $analogous_sensor->sensor->device->report->$address; // 0, 400
                                   if($analogous_sensor->sensor->fix_values_out_of_range === 1) {

                                       if($valorReport < $disposition->scale_min) {
                                           $valorReport = $disposition->scale_min;
                                       } else {
                                           if($valorReport > $disposition->scale_max) {
                                               $valorReport = $disposition->scale_max;
                                           }
                                       }

                                   }
                                   $ingMin = $disposition->sensor_min;
                                   $ingMax = $disposition->sensor_max;
                                   $escalaMin = $disposition->scale_min;
                                   $escalaMax = $disposition->scale_max;
                                   if($escalaMin == null && $escalaMax == null) {
                                       $data = ($ingMin * $valorReport) + $ingMax;
                                   } else {
                                       $f1 = $ingMax - $ingMin;
                                       $f2 = $escalaMax - $escalaMin;
                                       $f3 = $valorReport - $escalaMin;
                                       if($f2 == 0) {
                                           $data = ((0)*($f3)) + $ingMin ;
                                       } else {
                                           $data = (($f1/$f2)*($f3)) + $ingMin ;
                                       }
                                   }
                                   $interpreters = $analogous_sensor->sensor->type->interpreters;
                                   if(count($interpreters) > 0) {
                                       if($interpreter = $interpreters->where('value',(int) $data)->first()) {
                                           $data = $interpreter->name;
                                       }
                                   }

                                   $color = 'success';
                                   $ranges = $analogous_sensor->sensor->ranges;
                                   if (count($ranges) > 0) {
                                       foreach($ranges as $range) {
                                           if((float)$data >= $range->min && (float)$data <= $range->max) {
                                               $color = $range->color;
                                           }
                                       }
                                   }

                                   $sensor_name = $analogous_sensor->sensor->name;
                                   $unit = $disposition->unit->name;
                               }
                               }
                                   array_push($value,$data);
                               }

                                $value = number_format(collect($value)->sum(),$disposition->precision,',','');

                            @endphp
                            <div class="px-2 py-1 bg-secondary rounded overflow-hidden position-relative text-white mb-1 text-center " >
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    {{ $value }}
                                    <span class="fs-nano">
                                        {{ strtoupper($unit) }}
                                    </span>

                                </span>
                                        <small class="m-0 l-h-n font-weight-bolder fs-nano">{{ $sensor_name}}</small>
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div class="col-xl-2">
                @foreach($types as $key => $type)
                    @if($key == 'ee-factor-de-potencia' )
                        @foreach($type as $analogous)
                            @php
                                $value = array();

                               foreach($analogous as $analogous_sensor) {
                                   if(isset($analogous_sensor)) {
                                    $address = $analogous_sensor->sensor->full_address;
                               if(!$disposition = $analogous_sensor->sensor->dispositions()->where('id',$analogous_sensor->sensor->default_disposition)->first()){
                                   $disposition = $analogous_sensor->sensor->dispositions()->first();
                               }
                               if($disposition) {

                                   $valorReport = $analogous_sensor->sensor->device->report->$address; // 0, 400
                                   if($analogous_sensor->sensor->fix_values_out_of_range === 1) {

                                       if($valorReport < $disposition->scale_min) {
                                           $valorReport = $disposition->scale_min;
                                       } else {
                                           if($valorReport > $disposition->scale_max) {
                                               $valorReport = $disposition->scale_max;
                                           }
                                       }

                                   }
                                   $ingMin = $disposition->sensor_min;
                                   $ingMax = $disposition->sensor_max;
                                   $escalaMin = $disposition->scale_min;
                                   $escalaMax = $disposition->scale_max;
                                   if($escalaMin == null && $escalaMax == null) {
                                       $data = ($ingMin * $valorReport) + $ingMax;
                                   } else {
                                       $f1 = $ingMax - $ingMin;
                                       $f2 = $escalaMax - $escalaMin;
                                       $f3 = $valorReport - $escalaMin;
                                       if($f2 == 0) {
                                           $data = ((0)*($f3)) + $ingMin ;
                                       } else {
                                           $data = (($f1/$f2)*($f3)) + $ingMin ;
                                       }
                                   }
                                   $interpreters = $analogous_sensor->sensor->type->interpreters;
                                   if(count($interpreters) > 0) {
                                       if($interpreter = $interpreters->where('value',(int) $data)->first()) {
                                           $data = $interpreter->name;
                                       }
                                   }

                                   $color = 'success';
                                   $ranges = $analogous_sensor->sensor->ranges;
                                   if (count($ranges) > 0) {
                                       foreach($ranges as $range) {
                                           if((float)$data >= $range->min && (float)$data <= $range->max) {
                                               $color = $range->color;
                                           }
                                       }
                                   }

                                   $sensor_name = $analogous_sensor->sensor->name;
                                   $unit = $disposition->unit->name;
                               }
                               }
                                   array_push($value,$data);
                               }

                                $value = number_format(collect($value)->sum(),$disposition->precision,',','');

                            @endphp
                            <div class="px-2 py-1 bg-secondary rounded overflow-hidden position-relative text-white mb-1 text-center " >
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    {{ $value }}
                                    <span class="fs-nano">
                                        {{ strtoupper($unit) }}
                                    </span>

                                </span>
                                        <small class="m-0 l-h-n font-weight-bolder fs-nano">{{ $sensor_name}}</small>
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
        <!-- right slider panel backdrop : activated on mobile, must be place immideately after right slider closing tag -->
        <div class="slide-backdrop" data-action="toggle" data-class="slide-on-mobile-right-show" data-target="#js-slide-right"></div>


    </div>
</div>
    <div class="d-flex flex-grow-1 p-0 shadow-0">
      <!-- middle content area -->
        <div class="d-flex flex-column flex-grow-1 bg-white">
            <div class="row">
                <div class="col-xl-12 col-lg-12" >
                    <div id="panel-1" class="panel mb-1 shadow-0 border-0">
                        <div class="panel-container show">
                            <div class="panel-content p-1">
                                <div class="row">
                                    <div class="col-xl-3" id="energy-values-container" >
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-secondary btn-xs active" onclick="getEnergyChartContainer('thisWeek');">
                                                        <input type="radio" name="energyOptions" id="option1"  checked="checked"> Esta semana
                                                    </label>
                                                    <label class="btn btn-outline-secondary btn-xs" onclick="getEnergyChartContainer('thisMonth');">
                                                        <input type="radio" name="energyOptions" id="option2" > Este Mes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 cursor-pointer" id="energy-values" onclick="downloadEnergyData()">
                                            @php
                                                $s = array();
                                            @endphp
                                            @foreach($types as $key => $type)
                                                @if($key == 'ee-e-activa' || $key == 'ee-e-reactiva' || $key == 'ee-e-aparente' )
                                                    @foreach($type as $analogous)
                                                        @include('water-management.dashboard.views.electric.analogous',[
                                                            'class' => 'bg-success-300',
                                                            'icon' => 'fa-battery-bolt',
                                                            'function' => 'sum'
                                                        ])

                                                        @php
                                                            $sensors = array();
                                                                foreach($analogous as $analogous_sensor) {

                                                                    array_push($s,$analogous_sensor->sensor->id);
                                                                }
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 h-100" id="energy-chart-container">

                                    </div>
                                    @php
                                        $energy_sensors = implode(',',$s);
                                    @endphp
                                    <input type="hidden" id="energy-sensors" value="{{ $energy_sensors }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12" >
                    <div id="panel-2" class="panel mb-1 shadow-0 border-0">
                        <div class="panel-container show">

                            <div class="panel-content p-1">

                                <div class="row">
                                    <div class="col-xl-3" id="stream-values-container" >
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-secondary btn-xs active" onclick="streamOptions('average');">
                                                        <input type="radio" name="streamOptions" value="average" checked="checked"> Promedio
                                                    </label>
                                                    <label class="btn btn-outline-secondary btn-xs"  onclick="streamOptions('detail');">
                                                        <input type="radio" name="streamOptions" value="detail" > Detalle
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-xl-12 cursor-pointer" id="stream-values" onclick="downloadStreamData()">
                                                @php
                                                    $s = array();
                                                @endphp
                                                @foreach($types as $key => $type)
                                                    @if($key == 'ee-corriente')
                                                        @foreach($type as $analogous)
                                                            @if(!$loop->first)
                                                                @php
                                                                    foreach($analogous as $analogous_sensor) {

                                                                        array_push($s,$analogous_sensor->sensor->id);
                                                                    }
                                                                @endphp
                                                                @include('water-management.dashboard.views.electric.analogous',[
                                                                'class' => 'bg-warning-600',
                                                                'icon' => 'fa-bars',
                                                                'function' => 'avg'
                                                            ])
                                                            @else
                                                                @php
                                                                    $sensors = array();
                                                                        foreach($analogous as $analogous_sensor) {

                                                                            array_push($sensors,$analogous_sensor->sensor->id);
                                                                        }
                                                                           $stream_sensor = implode(',',$sensors);
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-9" id="stream-chart-container">

                                    </div>
                                    @php
                                        $stream_sensors = implode(',',$s);
                                    @endphp
                                    <input type="hidden" id="stream-sensors" value="{{ $stream_sensors }}">
                                    <input type="hidden" id="ss" value="{{ $stream_sensor }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-2">
                <div class="col-12" >
                    <div id="panel-3" class="panel mb-1 shadow-0 border-0">
                        <div class="panel-container show ">
                            <div class="panel-content p-1">
                                <div class="row">
                                    <div class="col-xl-3" id="tension-values-container" >
                                        <div class="row">
                                            <div class="col-xl-8">
                                                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-secondary btn-xs active" onclick="tensionOptions('average');">
                                                        <input type="radio" name="tensionOptions" value="average" checked="checked"> Promedio
                                                    </label>
                                                    <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');">
                                                        <input type="radio" name="tensionOptions" value="detail" > Detalle
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-secondary btn-xs active" onclick="handleTension('LL');">
                                                        <input type="radio" name="TensionType" value="LL"  checked="checked"> LL
                                                    </label>
                                                    <label class="btn btn-outline-secondary btn-xs" onclick="handleTension('LN');">
                                                        <input type="radio" name="TensionType" value="LN" > LN
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 cursor-pointer" id="tension-values" onclick="downloadTensionData()">
                                        @php
                                            $s = array();
                                        @endphp
                                        @foreach($types as $key => $type)
                                            @if($key == 'ee-tension-l-l')
                                                @foreach($type as $analogous)
                                                    @if(!$loop->first)
                                                        @php
                                                                foreach($analogous as $analogous_sensor) {
                                                                    array_push($s,$analogous_sensor->sensor->id);
                                                                }
                                                        @endphp
                                                        @include('water-management.dashboard.views.electric.analogous',[
                                                        'class' => 'bg-primary-300',
                                                        'icon' => 'fa-bolt',
                                                        'function' => 'avg'
                                                    ])
                                                    @else
                                                        @php
                                                        $ll_avr = array();
                                                            foreach($analogous as $analogous_sensor) {

                                                                array_push($ll_avr,$analogous_sensor->sensor->id);
                                                            }
                                                               $ll_avr = implode(',',$ll_avr);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9" id="tension-chart-container"></div>
                                    @php
                                        $ln = array();
                                    @endphp
                                    @foreach($types as $key => $type)
                                        @if($key == 'ee-tension-l-n')
                                            @foreach($type as $analogous)
                                           @if(!$loop->first)
                                                @php

                                                    foreach($analogous as $analogous_sensor) {
                                                        array_push($ln,$analogous_sensor->sensor->id);
                                                    }
                                                @endphp
                                            @else
                                                @php
                                                    $ln_avr = array();
                                                    foreach($analogous as $analogous_sensor) {
                                                        array_push($ln_avr,$analogous_sensor->sensor->id);
                                                    }
                                                @endphp
                                            @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @php
                                        $tension_sensors = implode(',',$s);
                                        $ln = implode(',',$ln);
                                        $ln_avr = implode(',',$ln_avr);
                                    @endphp
                                    <input type="hidden" value="{{ $ll_avr }}" id="ll-avr">
                                    <input type="hidden" value="{{ $ln }}" id="ts-ln">
                                    <input type="hidden" value="{{ $ln_avr }}" id="ln_avr">
                                    <input type="hidden" value="{{ $tension_sensors }}" id="ts">
                                </div>
                                </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-2">
                <div class="col-12" >
                    <div id="panel-4" class="panel shadow-0 mb-0 border-0">
                        <div class="panel-container show">
                            <div class="panel-content p-1" >
                                <div class="row">
                                    <div class="col-xl-3" id="power-values-container">
                                        <div class="row">
                                            @php
                                                $s = array();
                                                $avr = array();
                                                $label = '';
                                            @endphp
                                            <div class="col-xl-12">
                                                <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
                                                    @foreach($types as $key => $type)
                                                        @if($key == 'ee-p-act-u')
                                                        @foreach($type as $analogous)
                                                            @php
                                                                foreach($analogous as $analogous_sensor) {
                                                                    array_push($avr,$analogous_sensor->sensor->id);
                                                                    $label = 'Pot. Líneas';
                                                                }
                                                            @endphp
                                                        @endforeach
                                                        @else
                                                           @php
                                                            $label = 'Pot. Líneas';
                                                           @endphp
                                                        @endif
                                                    @endforeach
                                                        <label class="btn btn-outline-secondary btn-power btn-xs active"   onclick="powerOptions('pot-lineas'); handlePower('pot-lineas');">
                                                            <input type="radio" name="sensors" id="checkpot-lineas" class="powsensors" value="{{ implode(',',$avr) }}" checked="checked" > {{ $label }}
                                                        </label>
                                                    @foreach($types as $key => $type)

                                                        @php
                                                            $powerS = array();
                                                            $label = '';
                                                        @endphp
                                                        @if($key == 'ee-p-activa' || $key == 'ee-p-reactiva' || $key == 'ee-p-aparente')
                                                            @foreach($type as $analogous)
                                                                @php

                                                                        foreach($analogous as $analogous_sensor) {
                                                                            array_push($s,$analogous_sensor->sensor->id);
                                                                            array_push($powerS,$analogous_sensor->sensor->id);
                                                                            if($key == 'ee-p-activa') {
                                                                                $label = 'Activa';
                                                                            } elseif( $key == 'ee-p-reactiva') {
                                                                                $label = 'Reactiva';
                                                                            } else {
                                                                                $label = 'Aparente';
                                                                            }
                                                                         }


                                                                @endphp
                                                            @endforeach
                                                            <label class="btn btn-outline-secondary btn-power btn-xs align-items-center"  onclick="powerOptions('{{ $label  }}'); handlePower('NOPL');">
                                                                <input type="radio" name="sensors" id="check{{$label}}" class="powsensors" value="{{ implode(',',$powerS) }}" > {{ $label }}
                                                            </label>
                                                            @php
                                                                $power_sensors = implode(',',$s);
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 cursor-pointer" id="power-values" onclick="downloadPowerData()">
                                                @foreach($types as $key => $type)
                                                    @if($key == 'ee-p-act-u')

                                                        @foreach($type as $analogous)

                                                            @include('water-management.dashboard.views.electric.analogous',[
                                                                'class' => 'bg-danger-300',
                                                                'icon' => 'fa-tachometer',
                                                                'function' => 'avg'
                                                            ])
                                                            @if($key == 'ee-p-activa')
                                                                @php
                                                                    $sensors = array();
                                                                        foreach($analogous as $analogous_sensor) {

                                                                            array_push($sensors,$analogous_sensor->sensor->id);
                                                                        }
                                                                           $power_sensor = implode(',',$sensors);
                                                                @endphp
                                                            @endif
                                                        @endforeach

                                                    @endif
                                                    @if($key == 'ee-p-activa' || $key == 'ee-p-reactiva' || $key == 'ee-p-aparente' )

                                                        @foreach($type as $analogous)

                                                            @if($key == 'ee-p-activa')
                                                                @php
                                                                    $sensors = array();
                                                                        foreach($analogous as $analogous_sensor) {

                                                                            array_push($sensors,$analogous_sensor->sensor->id);
                                                                        }
                                                                           $power_sensor = implode(',',$sensors);
                                                                @endphp
                                                            @endif
                                                        @endforeach

                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xl-9" id="power-chart-container"></div>

                                    <input type="hidden" id="power-sensors" value="{{ $power_sensors }}">
                                    <input type="hidden" id="ps" value="{{ $power_sensor }}">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- right slider panel : must have unique ID -->
    </div>
@if(count($check_point_kpis ) > 0)

    @foreach($check_point_kpis as $kpi)
        <div class="row mt-4">
            @include('water-management.dashboard.partials.kpi.cost-kpi',['fullView' => 'full'])
        </div>
    @endforeach

@endif
<input type="hidden" value="LL" id="tension-type">
<input type="hidden" value="pot-lineas" id="power-type">
<input type="hidden" value="{{ implode(',',$avr) }}" id="power-options">
<input type="hidden" value="average" id="tension-options">
<input type="hidden" value="average" id="stream-options">
<script>


    $(function()
    {
        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            })
        })
    });

    setInterval(function(){
        getEnergyValues();
        getPowerValues();
        getTensionValues();
        getStreamValues();
    },10000);
    getEnergyChartContainer('thisWeek');
    getTensionChartContainer();
    getStreamChartContainer('avg');
    getPowerChartContainer();
    function getEnergyValues()
    {
        var sensors = $('#energy-sensors').val();
        $.get('/getEnergyValues?sensors='+sensors,function(data){
            $('#energy-values').html(data);
        });
    }

    function downloadEnergyData() {
        let date = $('#date').val();
        var sensors = $('#energy-sensors').val();
        location.href = '/downloadDataFromEnergy?dates='+date+'&sensors='+sensors+'&name=Energia';
    }

    function downloadConsumptions() {
        location.href = '/downloadConsumptions/{{ $subZone->id }}';
    }
    function getPowerValues()
    {
        var type = $('#power-type').val();

        if(type === 'pot-lineas') {
            var sensors = $('#power-options').val();
        } else {
            var sensors = $('#power-sensors').val();
        }

        $.get('/getPowerValues?sensors='+sensors,function(data){
            $('#power-values').html(data);
        });
    }

    function downloadPowerData() {
        let date = $('#date').val();
        var type = $('#power-type').val();

        if(type === 'pot-lineas') {
            var sensors = $('#power-options').val();
            var name = 'Potencia_lineas';
        } else {
            var sensors = $('#power-sensors').val();
            var name = 'Potencias';
        }
        location.href = '/downloadDataFromEnergy?dates='+date+'&sensors='+sensors+'&name='+name;
    }
    function tensionOptions(options)
    {
        $('#tension-options').val(options);
        getTensionChartContainer();
    }

    function powerOptions(type)
    {
        $('#power-options').val($('#check'+type).val());
        if(type === 'pot-lineas') {
            $('#power-type').val('pot-lineas');
        } else {
            $('#power-type').val('NOPL');
        }
        getPowerChartContainer();
    }

    function streamOptions(options)
    {
        $('#stream-options').val(options);
        getStreamChartContainer();
    }
    function handleTension(type){
        $('#tension-type').val(type);
        getTensionValues();
        getTensionChartContainer();
    }

    function handlePower(type){
        $('#power-type').val(type);
        getPowerValues();
        getPowerChartContainer();
    }
    function getTensionValues()
    {
        var type = $('#tension-type').val();

        if(type === 'LL') {
            var sensors = $('#ts').val();
        } else {
            var sensors = $('#ts-ln').val();
        }

        $.get('/getTensionValues?sensors='+sensors,function(data){
            $('#tension-values').html(data);
        });
    }

    function downloadTensionData() {
        let date = $('#date').val();
        var type = $('#tension-type').val();

        if(type === 'LL') {
            var sensors = $('#ts').val();
            var name = 'Tension_LL'
        } else {
            var sensors = $('#ts-ln').val();
            var name = 'Tension_LN'
        }
        location.href = '/downloadDataFromEnergy?dates='+date+'&sensors='+sensors+'&name='+name;
    }
    function getStreamValues()
    {
        var sensors = $('#stream-sensors').val();
        $.get('/getStreamValues?sensors='+sensors,function(data){
            $('#stream-values').html(data);
        });
    }

    function downloadStreamData() {
        let date = $('#date').val();
        var sensors = $('#stream-sensors').val();
        location.href = '/downloadDataFromEnergy?dates='+date+'&sensors='+sensors+'&name=Corriente';
    }

</script>

