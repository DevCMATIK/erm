<ul class="list-group bg-white rounded-plus m-2">
    @foreach($zones  as $zone)
        @if($loop->last)
            <li class="list-group-item p-0 cursor-pointer rounded-bottom" data-remote="true" href="#collapsed_{{$zone->id}}" id="parent_{{$zone->id}}" data-toggle="collapse" data-parent="#collapsed_{{$zone->id}}">
                <h5 class="text-dark p-3 m-0 font-weight-bolder" id="zone_a_{{ $zone->id }}">{{$zone->name}}</h5>
            </li>
            @if(count($zone->sub_zones) > 0)
                <ul class="collapse list-group rounded-plus"  id="collapsed_{{$zone->id}}">
                    @foreach ($zone->sub_zones as $sub_zone)
                        @if($sub_zone->configuration && Sentinel::getUser()->inSubZone($sub_zone->id))
                            <a class="list-group-item pl-6 text-primary fs-xl   " id="sub_zone_a_{{ $sub_zone->id }}" href="/dashboard/{{ $sub_zone->id }}"><i class="fas fa-chart-bar"></i> {{ $sub_zone->name }}</a>

                        @endif
                    @endforeach
                </ul>
            @endif
        @else
            <li class="list-group-item p-0 cursor-pointer" data-remote="true" href="#collapsed_{{$zone->id}}" id="parent_{{$zone->id}}" data-toggle="collapse" data-parent="#collapsed_{{$zone->id}}">
                <h5 class="text-dark p-3 m-0 font-weight-bolder">{{$zone->name}}</h5>
            </li>
            @if(count($zone->sub_zones) > 0)
                <ul class="collapse list-group rounded-plus"  id="collapsed_{{$zone->id}}">
                    @foreach ($zone->sub_zones as $sub_zone)
                        @if($sub_zone->configuration && Sentinel::getUser()->inSubZone($sub_zone->id))
                            <a class="list-group-item pl-6 text-primary fs-xl" id="sub_zone_a_{{ $sub_zone->id }}" href="/dashboard/{{ $sub_zone->id }}"><i class="fas fa-chart-bar"></i> {{ $sub_zone->name }}</a>

                        @endif
                    @endforeach
                </ul>
            @endif
        @endif
    @endforeach
</ul>
