<div class="row">
    <div class="col-xl-3 rounded-plus" style="font-size: 0.5em" id="accordion">
        <ul class=" list-group bg-white rounded-plus" >
            @foreach($subZone->check_points as $checkPoint)
                @if($loop->last)
                    <li class="ist-group-item bg-primary  p-0 cursor-pointer rounded-bottom" data-remote="true" href="#collapsed_{{$checkPoint->id}}" id="parent_{{$checkPoint->id}}" data-toggle="collapse" data-parent="#collapsed_{{$checkPoint->id}}">
                        <h5 class="text-white p-1 py-3 m-0 font-weight-bolder">{{ $checkPoint->type->name }} - {{ $checkPoint->name }}
                            <a href="javascript:void(0);" onclick="showGrid({{ $checkPoint->id }});" class="btn-default btn-xs p-1 pull-right"><i class="fal fa-table"></i></a>
                        </h5>
                    </li>
                    @if(count($checkPoint->devices) > 0)
                        <ul class="collapse list-group rounded-plus"  id="collapsed_{{$checkPoint->id}}">
                            @forelse ($checkPoint->devices as $device)
                                <li class="list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsedDevice_{{$device->id}}" id="parentDevice_{{$device->id}}" data-toggle="collapse" data-parent="#collapsedDevice_{{$device->id}}">
                                    <h6 class="text-dark p-3 m-0">{{ $device->type->name }} - {{ $device->name }}</h6>
                                </li>
                                @if(count($device->sensors) > 0)
                                    <ul class="collapse list-group rounded-plus"  id="collapsedDevice_{{$device->id}}">
                                        @forelse ($device->sensors as $sensor)
                                            <a class="list-group-item pl-6 text-primary fs-md cursor-pointer"
                                               @if($sensor->address->configuration_type == 'scale')
                                               onclick="getScaleForm({{ $sensor->id }})"
                                               @else
                                               onclick="getBooleanForm({{ $sensor->id }})"
                                                @endif ><i class="fas fa-cog"></i> {{ $sensor->address->name }}{{ $sensor->address_number }} - {{ $sensor->name }}</a>
                                        @empty
                                            Sin sensores creados.
                                        @endforelse
                                    </ul>
                                @endif
                            @empty
                                Sin dipositivos creados.
                            @endforelse
                        </ul>
                    @endif
                @else
                    <li class=" list-group-item p-0 bg-primary cursor-pointer" data-remote="true" href="#collapsed_{{$checkPoint->id}}" id="parent_{{$checkPoint->id}}" data-toggle="collapse" data-parent="#collapsed_{{$checkPoint->id}}">
                        <h5 class="text-white p-1 py-3 m-0 font-weight-bolder">{{ $checkPoint->type->name }} - {{ $checkPoint->name }}
                            <a href="javascript:void(0);" onclick="showGrid({{ $checkPoint->id }});" class="btn-default btn-xs p-1 pull-right"><i class="fal fa-table"></i></a>

                        </h5>

                    </li>
                    @if(count($checkPoint->devices) > 0)
                        <ul class="collapse list-group rounded-plus"  id="collapsed_{{$checkPoint->id}}">
                            @foreach ($checkPoint->devices as $device)
                                <li class=" list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsedDevice_{{$device->id}}" id="parentDevice_{{$device->id}}" data-toggle="collapse" data-parent="#collapsedDevice_{{$device->id}}">
                                    <h6 class="text-dark p-3 m-0">{{ $device->type->name }} - {{ $device->name }}</h6>
                                </li>
                                @if(count($device->sensors) > 0)
                                    <ul class="collapse list-group rounded-plus"  id="collapsedDevice_{{$device->id}}">
                                        @foreach ($device->sensors as $sensor)
                                            <a class="list-group-item pl-6 cursor-pointer text-primary fs-md"
                                               @if($sensor->address->configuration_type == 'scale')
                                               onclick="getScaleForm({{ $sensor->id }})"
                                               @else
                                               onclick="getBooleanForm({{ $sensor->id }})"
                                                @endif ><i class="fas fa-cog"></i> {{ $sensor->address->name }}{{ $sensor->address_number }} - {{ $sensor->name }}</a>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>

    <div class="col-xl-9" id="sensorForm">

    </div>
</div>
<script>
    function getBooleanForm(sensor) {
        $.get('/getBooleanForm/'+sensor, function(data) {

            $('#sensorForm').html(data);
        });
    }

    function getScaleForm(sensor) {
        $.get('/getScaleForm/'+sensor, function(data) {
            $('#sensorForm').html(data);
        });
    }

    function showGrid(check_point) {
        $.get('/check-point-grid/'+check_point, function(data) {
            $('#sensorForm').html(data);
        });
    }
</script>
