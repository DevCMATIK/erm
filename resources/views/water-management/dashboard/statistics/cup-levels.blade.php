<div class="row my-2">
    @foreach($zones as $zone => $sub_zones)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 my-2">
            <h5 class=" py-1 font-weight-bolder border-bottom">
                {{ $zone }}
            </h5>
            @foreach($sub_zones->chunk(2) as $chunked_sub_zones)
                <div class="row">
                    @foreach($chunked_sub_zones as $check_point)
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="row mt-1 px-2">
                                @php
                                    if(!isset($check_point['data']['value'])) {
                                        $value = 0;
                                    } else {
                                        $value = $check_point['data']['value'];
                                    }

                                     if(!isset($check_point['data']['unit'])) {
                                            $unit = '%';
                                     } else {
                                            $unit = $check_point['data']['unit'];
                                     }

                                 if(!isset($check_point['data']['color'])) {
                                            $color = 'secondary';
                                     } else {
                                            $olor = $check_point['data']['color'];
                                     }

                                @endphp
                                <div class="col-xl-8 col-8 py-4 pl-2  bg-gray-200 rounded-plus border-bottom-right-radius-0 border-top-right-radius-0 fs-xl ">{{ $check_point['check_point'] ?? null }}</div>
                                <div class="col-xl-4 col-4  text-center py-4 @if($color === null  || $color ?? null == 'success') bg-primary @else bg-{{ $color ?? 'secondary' }} @endif text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0 fs-xl font-weight-bolder" >
                                    <a href="/dashboard/{{ $check_point['sub_zone_id'] ?? 'id' }}" class="text-white">{{ number_format($value,1,',','').' '.$unit}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>

