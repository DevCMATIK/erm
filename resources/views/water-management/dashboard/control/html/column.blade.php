<a class="d-block  rounded-plus mb-1 px-2 py-1 text-center" href="/getDataAsChart/{{ $analogous->sensor->device_id }}/{{ $analogous->sensor->id }}"  {!! makeLinkRemote() !!} id="d_{{$analogous->id}}_{{$analogous->sensor->id}}">
    <span class="font-weight-bold text-dark fs-md" >{{ strtoupper($analogous->sensor->name) }}</span>
    @if($se->device->check_point->type->slug != 'copas')
        <style>
            .progress-bar {
                width: 120% !important;
            }
        </style>
    @endif

    @php
        if($analogous->sensor->type->id == 1 && optional($disposition->unit)->name == 'mt') {
            $sensor_mt = true;
        } else {
            $sensor_mt = false;
        }
    @endphp
    <div class="progress progress-bar-vertical @if($se->device->check_point->type->slug == 'copas') prog-copa @endif mt-0" style="margin-top: 0px !important;">
        <div class="progress-bar @if($off) bg-fusion-50 @else bg-{{ $color }} @endif  progress-bar progress-bar-striped @if($digital && $digital && $digital->means_up == $digitalValue)  progress-bar-animated  @endif progress-bar-flip-vertical" style="width: 100%; height:{{ $percentaje }}%;" role="progressbar">
            @if($sensor_mt)
                <h2 class=" mt-n6 text-white "  ><span class="font-weight-bolder " style=" @if($data >= 100) font-size: 0.7em @else font-size: 0.8em @endif !important;">{{ number_format(((float)$analogous->sensor->max_value + (float)$data),$disposition->precision) }}</span> </h2>
            @else
                @if($se->device->check_point->type->slug == 'relevadoras')
                    <h2 class=" mb-0 text-white"><span class="font-weight-bolder " style=" font-size: 0.7em !important;">{{ number_format(round($data,1),1) }}</span> <span class="fs-nano text-white">{{ strtoupper(optional($disposition->unit)->name) }}</span> </h2>

                @else
                    <h2 class=" mb-0 text-white"><span class="font-weight-bolder " style=" font-size: 0.8em !important;">{{ number_format($data,$disposition->precision) }}</span> <span class="fs-nano text-white">{{ strtoupper(optional($disposition->unit)->name) }}</span> </h2>

                @endif
            @endif
        </div>
    </div>
    @if($disposition->unit->name != '%')
        <span class="fs-nano m-0 mb-1 text-dark">{{$analogous->sensor->max_value}} {{ strtoupper($disposition->unit->name) }}</span><br>
    @endif
    @if($digital && $digital && $digital->means_down == $digitalValue)
        <i class="fas fa-caret-down fa-2x text-dark"></i>
        <span class="d-block font-weight-bold fs-nano text-dark ">{{  strtoupper($digital_label) }}</span>
    @else
        <i class="fas fa-caret-up fa-2x text-dark"></i>
        <span class=" d-block font-weight-bold fs-nano  text-dark">{{  strtoupper($digital_label) }}</span>
    @endif

    @if($se->device->check_point->type->slug == 'copas')
        <hr>
        <p class="text-center text-muted fs-sm mt-1">
        @foreach($analogous->sensor->non_selected_dispositions as $dis)
           @if($dis && $dis != '')
                @php
                       $ingMin = $dis->sensor_min;
                       $ingMax = $dis->sensor_max;
                       $escalaMin = $dis->scale_min;
                       $escalaMax = $dis->scale_max;
                       if($escalaMin == null && $escalaMax == null) {
                           $dat = ($ingMin * $valorReport) + $ingMax;
                       } else {
                           $f1 = $ingMax - $ingMin;
                           $f2 = $escalaMax - $escalaMin;
                           $f3 = $valorReport - $escalaMin;
                           if($f2 == 0) {
                               $dat = ((0)*($f3)) + $ingMin ;
                           } else {
                               if($f1 === 0 || $f2 === 0) {
                                    $dat = ((0)*($f3)) + $ingMin ;
                               } else {
                                    $dat = (($f1/$f2)*($f3)) + $ingMin ;
                               }
                           }
                       }

                        if($dis->unit->name == 'm3') {
                            if($data == 0 || $dat == 0) {
                                $max_vol = 0;
                            } else {
                                   $max_vol = $dat * 100 / $data;
                            }

                        }
                @endphp
                    {{ number_format((float)$dat,$dis->precision).' '.strtoupper($dis->unit->name) }} <br>
            @endif
        @endforeach
            @if(isset($max_vol) && $max_vol != '')
                Vol. Max {{ number_format($max_vol,1,'.','') }} M3
            @endif
        </p>
    @endif
</a>
