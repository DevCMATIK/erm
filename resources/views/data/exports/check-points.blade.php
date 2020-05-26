<div class="form-group  m-0 rounded-top">
    <input type="text" class="form-control form-control-lg shadow-inset-2 m-0" id="js_list_accordion_filter_check_point" placeholder="Filtrar Puntos de control ">
</div>
<div id="js_list_accordion_check_points" class="accordion accordion-hover accordion-clean">
    @foreach($check_points as $check_point)
        <div class="card border-top-left-radius-0 border-top-right-radius-0">
            <div class="card-header ">
                <a href="javascript:void(0);"
                   class="card-title collapsed"
                   data-toggle="collapse"
                   data-target="#sub_zone_list_{{ $check_point->id }}"
                   aria-expanded="false"
                   data-filter-tags="{{ strtolower($check_point->name) }} @foreach($check_point->devices as $device) {{ strtolower($device->name) }} @endforeach">
                    <i class="fal fa-filter width-2 fs-xl"></i>
                    {{ $check_point->sub_zones->first()->name.' - '.$check_point->name }} <div class="ml-3" id="header_{{ $check_point->id }}"></div>
                    <span class="ml-auto">
                                            <span class="collapsed-reveal">
                                                <i class="fal fa-chevron-up fs-xl"></i>
                                            </span>
                                            <span class="collapsed-hidden">
                                                <i class="fal fa-chevron-down fs-xl"></i>
                                            </span>
                                        </span>
                </a>
            </div>
            <div id="sub_zone_list_{{ $check_point->id }}" class="collapse"  data-parent="#js_list_accordion_check_points">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($check_point->devices  as $key => $device)
                            @foreach($device->sensors->sortByDesc('address.configuration_type') as $sensor)
                                <li class="list-group-item cursor-pointer" id="{{$check_point->id}}_{{ $sensor->id }}" data-remote="true" href="#collapsed_{{ $sensor->id }}" id="parent_{{$check_point->id}}" data-toggle="collapse" data-parent="#collapsed_{{ $check_point->id }}">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input sensors" value="{{ $sensor->id }}" name="sensors[]">
                                        <span class="custom-control-label">{{ $sensor->name }}</span>
                                    </label>
                                </li>
                            @endforeach

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    @endforeach
</div>
<span class="filter-message js-filter-message"></span>
<script>
    $(document).ready(function(){
        initApp.listFilter($('#js_list_accordion_check_points'), $('#js_list_accordion_filter_check_point'));
    });
</script>
