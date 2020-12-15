<style>
     #js-nav-menu  .collapse-sign {
        color: #fff !important;
    }
</style>
<ul id="js-nav-menu" class="nav-menu">
    @foreach(getMainMenuItems() as $m)
        <li class="{{$m['class']}} text-white">
            <a href="{{ ($m['route'] != '')?route($m['route']):'javascript:void(0);' }}">
                <i class="fal fa-{{ $m['icon'] }} text-white"></i>
                <span class="nav-link-text text-white">{{ $m['name'] }}</span>
            </a>
            @if(count($m['children']) > 0)
                <ul>
                    @foreach($m['children'] as $child)
                        <li class="{{$child['class']}}">
                            <a href="{{ ($child['route'] != '')?route($child['route']):'javascript:void(0);'}}">
                                @if($child['icon'] != '')
                                    <i class="fal fa-{{ $child['icon'] }} text-white-50"></i>&nbsp;
                                @endif
                                <span class="nav-link-text text-white-50">{{ $child['name'] }}</span>
                            </a>
                            @if(count($child['children']) > 0)
                                <ul>
                                    @foreach($child['children'] as $childs)
                                        <li class="{{$childs['class']}}">
                                            <a href="{{ ($childs['route'] != '')?route($childs['route']):'javascript:void(0);' }}">
                                                @if($childs['icon'] != '')
                                                    <i class="fal fa-{{ $childs['icon'] }} text-white-50"></i>&nbsp;
                                                @endif
                                                <span class="nav-link-text text-white-50">{{ $childs['name'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
    @php
        $areas = \App\Domain\Client\Area\Area::whereHas('zones.sub_zones', $filter =  function($query){
           $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['zones.sub_zones' => $filter])->get();
    @endphp
    @foreach($areas->sortBy('name') as $area)
        @php

            $mainZones = $area->zones;
        @endphp
        @if(isset($mainZones) && count($mainZones) > 0)
            <li>
                <a href="javascript:void(0);">
                    <i class="fal @if($loop->first) fa-bolt @else fa-map-marker fa-flip-vertical @endif text-white"></i>
                    <span class="nav-link-text text-white">{{ $area->name }}</span>
                </a>
                <ul>
                @foreach($mainZones->sortBy('position') as $zone)
                        @if(count($zone->sub_zones) > 0)
                    <li >
                        <a href="javascript:void(0);">
                            <i class="fal {{ $area->icon }} text-white" id="zone_a_{{ $zone->id }}"></i>
                            <span class="nav-link-text text-white" id="zone_span_{{ $zone->id }}">{{ $zone->display_name }}</span>
                        </a>

                            <ul>
                                @if($area->name == 'Energía')
                                <li>
                                    <a class="nav-link-text text-white-50" id="energy_zone{{ $zone->id }}" href="/zone-resume/{{$zone->id}}">
                                        <span class="nav-link-text text-white-50">Resumen Energía</span></a>
                                </li>
                                @endif
                                @foreach($zone->sub_zones->sortBy('position') as $sub_zone)
                                    <li>
                                        <a class="nav-link-text text-white-50" id="sub_zone_a_{{ $sub_zone->id }}" href="@if($area->name == 'Energía') /dashboard-energy/{{ $sub_zone->id }} @else /dashboard/{{ $sub_zone->id }} @endif">
                                            <span class="nav-link-text text-white-50">{{ $sub_zone->name}}</span></a>
                                    </li>
                                @endforeach
                            </ul>

                    </li>
                        @endif
                @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>



