@extends('layouts.app')
@section('page-title','TestView')
@section('page-icon','key')
@section('page-content')
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
                                    <div class="col-xl-8 col-8 py-4 pl-2  bg-gray-200 rounded-plus border-bottom-right-radius-0 border-top-right-radius-0 fs-xl ">{{ $check_point['check_point'] }}</div>
                                    <div class="col-xl-4 col-4  text-center py-4 @if($check_point['data']['color'] === null  || $check_point['data']['color'] == 'success') bg-primary @else bg-{{ $check_point['data']['color'] }} @endif text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0 fs-xl font-weight-bolder" >
                                        <a href="/dashboard/{{ $check_point['sub_zone_id'] }}" class="text-white">{{ number_format($check_point['data']['value'],1,',','').' '.$check_point['data']['unit'] }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
