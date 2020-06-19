<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @forelse($subColumns  as  $column => $key)
                        <div class="@if(count($subColumns) == 1)offset-xl-3 col-xl-6 offset-sm-3 col-sm-6 @else col-xl-{{ 12 / count($subColumns) }} @endif p-2">
                            @switch(array_values(array_flip($key))[0])
                                @case('digital')
                                <div class="row border-bottom pb-2 mb-2">
                                    @foreach($sub_elements->unique('device_id') as $sub_element)
                                        @php
                                            $off = false;

                                        @endphp
                                        @if(count($inputs = $sub_element->digital_sensors->filter(function($item) {
                                             return ($item->use_as_digital_chart == 0 && ($item->sensor->address->slug == 'i' || $item->is_not_an_output == 1));
                                        })) > 0)

                                            @foreach($inputs as $digital_sensor)
                                                <div class="col-4 col-sm-4 col-md-3 col-xl-4">
                                                    @include('water-management.dashboard.control.digital-input',['digital_sensor' => $digital_sensor])
                                                </div>
                                            @endforeach

                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mt-2">
                                    @foreach($sub_elements->unique('device_id') as $sub_element)
                                        @php
                                            $off = false;

                                        @endphp
                                        @if(count($outputs = $sub_element->digital_sensors->filter(function($item) {
                                            return ($item->use_as_digital_chart == 0 && $item->sensor->address->slug == 'o' && $item->is_not_an_output != 1);
                                        })) > 0)

                                            @foreach($outputs as $digital_sensor)
                                                <div class="col-6 col-sm-6 col-md-6 col-xl-4">
                                                    @include('water-management.dashboard.control.digital-output',['digital_sensor' => $digital_sensor])
                                                </div>
                                            @endforeach

                                        @endif
                                    @endforeach
                                </div>

                                @break
                                @case('analogous')
                                <div class="row">
                                    @if($sub_elements->first()->check_point->grids->first())
                                        @php
                                            $columns = $sub_elements->first()->check_point->grids->pluck('column')->unique();
                                        @endphp
                                        @foreach($columns as $column)
                                            <div class="col">
                                                @foreach($sub_elements->first()->check_point->grids()->where('column',$column)->get() as $sensors)
                                                    @if($sensors->sensor_id === null)
                                                        <div class="d-block  rounded-plus mb-1 px-2 py-1 text-center" id="">
                                                            <h2 class=" mb-0  text-white ">
                                                                <span class="font-weight-bolder " style=" font-size: 0.9em !important;">blank</span>
                                                                <span class="fs-nano text-white">b</span>
                                                            </h2>
                                                            <span  class="font-weight-bold text-white  fs-nano">blank</span>
                                                        </div>
                                                    @else
                                                        @php
                                                            $analogous = $sub_elements->pluck('analogous_sensors')->collapse();
                                                            $analogous_sensor = $analogous->where('sensor_id',$sensors->sensor->id)->first();
                                                        @endphp
                                                        @include('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor])
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($sub_elements->unique('device_id') as $sub_element)
                                            @php
                                                $off = false;

                                            @endphp
                                            @foreach($sub_element->analogous_sensors->where('use_as_chart','<>',1)->chunk(6) as $chunk)
                                                <div class="@if(count($sub_element->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1)) > 6) col-xl-6 @else col @endif">
                                                    @foreach($chunk as $analogous_sensor)
                                                        @include('water-management.dashboard.control.analogous',['analogous_sensor' => $analogous_sensor])
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif

                                </div>
                                @break
                                @case('graph')
                                <div class="row">

                                    <div class="@if($sub_elements->first()->check_point->type()->first()->slug == 'copas' || $sub_elements->first()->check_point->type()->first()->slug == 'relevadoras') col-xl-8 offset-xl-2 col-sm-6 offset-sm-3 @else col-xl-4 offset-xl-4 col-sm-4 offset-xl-4 @endif ">
                                        @foreach($sub_elements->unique('device_id') as $se)
                                            @php
                                                $off = false;

                                            @endphp
                                            @include('water-management.dashboard.control.column', [
                                                 'analogous' => $se->analogous_sensors->where('use_as_chart',1)->first(),
                                                 'digital' => $se->digital_sensors->where('use_as_digital_chart',1)->first(),
                                            ])
                                        @endforeach
                                    </div>
                                </div>

                                @break
                            @endswitch
                        </div>


                    @empty
                        <div class="col-xl-12">
                            <div class="alert alert-info">
                                No ha cargado controles para mostrar.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@if($indicators)
    @foreach($indicators as $groupName => $group)
        <div class="row">
            <div class="col-xl-12">
                <div class="card my-2">
                    <div class="card-body">
                        <h5 class="mb-2">{{ $groupName }}</h5>
                        <div class="row">
                                @php
                                    $group_count = count($group);
                                @endphp
                            @foreach($group as $item)

                                <div class="col-xl-{{ 12 / $group_count }}">
                                    <div class="px-2 py-1 {{ $item['color'] }}  rounded overflow-hidden position-relative text-white mb-1 text-center "  >
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                                    <span class="text-white"  id="" >
                                                        <span class="hidden-md-down" style="font-size: 0.7em !important;">{{ $item['value'] }}</span>
                                                        <span class="hidden-lg-up">{{ $item['value'] }}</span>
                                                        <span class="fs-nano">
                                                        {{ $item['suffix'] }}
                                                        </span>
                                                    </span>
                                                <small class="m-0 l-h-n font-weight-bolder fs-nano">{{ $item['name'].' - '. $item['frame'] }}</small>
                                            </h3>
                                        </div>
                                    </div></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach;
@endif
<script>
    $(document).ready(function()
    {
        $('.onoffswitch input[type="checkbox"]').click(function(e){
            let element = $(this);
            let order;
            e.preventDefault();
            if(element.prop("checked") === true){
                order = 1;
            }
            else if(element.prop("checked") === false){
                order = 0;
            }
            confirmAction('Realmente desea ejecutar el comando?','', sendCommand);

            function sendCommand()
            {
                if(order === 0 ) {
                    element.prop('checked',false);
                } else {
                    element.prop('checked',true);
                }
                $.get('/sendCommand', {
                        element : element.attr('id'),
                        order : order
                    } ,function() {
                        toastr.success('Comando ejecutado');
                    }
                )
            }
        });
    });
</script>
