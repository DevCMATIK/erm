@php
    $off = false;
$states = array();
    foreach($sub_element as $ss){

         if(optional($ss->device)->from_bio == 1) {
            $state =  DB::connection('bioseguridad')
                ->table('reports')
                ->where('grd_id',$ss->device->internal_id)
                ->first()->state ?? null;
        } else {
           if(optional($ss->device)->from_dpl == 1) {
                $state = DB::connection('dpl')
                    ->table('reports')
                    ->where('grd_id',$ss->device->internal_id)
                    ->first()->state ?? false;
            } else {
               $state = optional(optional($ss->device)->report)->state;
            }
        }
        array_push($states,$state);


    }
    $state = array_reverse(\Illuminate\Support\Arr::sort($states))[0] ?? 0;
if($state== 0) {
            $off = true;
        }
@endphp
<div class="card rounded-plus mb-2 " id="sub_element_{{$sub_element->first()->id}}" style="min-height: 400px;">
    @if($sub_element->first()->active_alarm()->first())
        <script>activeAndNotAccused({{$sub_element->first()->id}});</script>
    @endif
    <a href="/dashboard/detail/{{ $sub_element->first()->check_point->id }}" class="cursor-pointer card-header p-2 text-center font-weight-bolder uppercase fs-xl @if($off) bg-secondary text-white @if($sub_element->first()->active_alarm()->first()) bg-danger text-white @endif @endif">
            {{ $sub_element->first()->check_point->name }}

    </a>
    <div class="card-body ">
        <div class="row">

            @forelse($sub_columns = optional($subColumns->where('sub_element',$sub_element->first()->id)->first())['sub_columns'] as $column => $key)
               <div class="@if(count($sub_columns) == 1 || $options['digital'] == 'only-outputs' ) @if($options['digital'] == 'only-outputs') col-xl-12 @else  @if(array_values(array_flip($key))[0] == 'graph') offset-2 col-8 @else offset-xl-4 col-xl-4  @endif @endif @else col-xl-{{ 12 / count($sub_columns) }} @endif p-2">
                    @switch(array_values(array_flip($key))[0])
                        @case('digital')
                                @if($options['digital'] == 'only-outputs')
                                    <div class="row">
                                        @foreach($sub_element as $se)
                                            @if($se->digital_sensors->filter(function($item) {
                                                return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o');
                                           })->count() == 0)
                                                <script>$('#sub_element_{{$se->id}}').remove()</script>
                                            @endif
                                           @foreach($se->digital_sensors->filter(function($item) {
                                                return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o');
                                           })->chunk(6) as $chunk)
                                                <div class="col-6">
                                                    @foreach($chunk as $digital_sensor)
                                                        @include('water-management.dashboard.control.digital-output',['digital_sensor' => $digital_sensor])
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @elseif($options['digital'] == 'outputs-as-states')
                                    <div class="row">
                                        @foreach($sub_element as $se)
                                             @foreach($se->digital_sensors->where('use_as_digital_chart','<>',1)->where('show_in_dashboard',1) as $digital_sensor)
                                                <div class="col-6 col-sm-6 col-md-4 col-xl-12">
                                                    @include('water-management.dashboard.control.digital-input',['digital_sensor' => $digital_sensor])
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @else
                                @endif
                        @break
                        @case('analogous')
                           @if($options['digital'] != 'only-outputs')
                           <div class="row">
                               @foreach($sub_element as $se)
                                   @foreach($se->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1) as $analogous_sensor)
                                   <div class="col-4 col-sm-4 col-md-4 col-xl-12">
                                       @include('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor])
                                   </div>
                                   @endforeach
                               @endforeach
                           </div>
                           @endif
                        @break
                        @case('graph')
                            @foreach($sub_element as $se)
                               @if($options['digital'] != 'only-outputs' && $se->analogous_sensors->where('use_as_chart',1)->where('show_in_dashboard',1)->first())
                               <div class="row">
                                   <div class=" @if($se->device->check_point->type->slug == 'copas')  offset-sm-0 col-sm-12 offset-xs-0 col-xs-12 offset-md-0 col-md-12  offset-xl-0 col-xl-12 @else  @if($columns == 2) offset-4 col-4  col-md-2 offset-md-5 col-xl-7 offset-xl-2 @else offset-4 col-4  col-md-4 offset-md-4 col-xl-10 offset-xl-1 @endif @endif">
                                       @include('water-management.dashboard.control.column', [
                                      'analogous' => $se->analogous_sensors->where('use_as_chart',1)->where('show_in_dashboard',1)->first(),
                                      'digital' => $se->digital_sensors->where('use_as_digital_chart',1)->where('show_in_dashboard',1)->first(),
                                    ])
                                   </div>
                               </div>

                           @endif
                            @endforeach
                        @break
                    @endswitch
               </div>
            @empty
               <div class="col-xl-12">
                   <div class="alert alert-info">
                       No hay sensores disponibles.
                   </div>
               </div>
                <script>$('#sub_element_{{ $sub_element->first()->id }}').remove()</script>
            @endforelse
        </div>
    </div>
</div>
