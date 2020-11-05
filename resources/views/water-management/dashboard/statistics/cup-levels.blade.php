@foreach($data->groupBy('zone')->chunk(2)  as $row)
    <div class="row my-2">
        @foreach($row as $key => $zones)
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 my-2">
                    <h5 class=" py-1 font-weight-bolder border-bottom">
                        {{ $key }}
                    </h5>
                @foreach($zones->sortBy('sub_zone_position')->chunk(2) as $chunk_zone)
                    <div class="row">
                        @foreach($chunk_zone as $zone)
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="row mt-1 px-2">
                                    <div class="col-xl-8 col-8 py-4 pl-2  bg-gray-200 rounded-plus border-bottom-right-radius-0 border-top-right-radius-0 fs-xl ">{{ $zone['label'] ?? $zone['check_point'] }}</div>
                                    <div class="col-xl-4 col-4  text-center py-4 @if($zone['color'] === null || $zone['color'] === 'success') bg-primary @else bg-{{ $zone['color'] }} @endif text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0 fs-xl font-weight-bolder" >
                                        <a href="/dashboard/{{ $zone['sub_zone_id'] }}" class="text-white">{{ $zone['value'] }}%</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endforeach

