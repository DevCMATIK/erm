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
                            
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>

