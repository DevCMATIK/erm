@if($analogous_sensor->no_chart_needed != 1)
    <a href="/getDataAsChart/{{ $analogous_sensor->sensor->device_id }}/{{ $analogous_sensor->sensor->id }}"
       @if($analogous_sensor->sensor->pre_text != '')
       data-toggle="popover"
       data-trigger="hover"
       data-placement="top"
       title=""
       data-content="{{ $analogous_sensor->sensor->max_value }} {{ optional(optional($disposition)->unit)->name }}  {{ $analogous_sensor->sensor->post_text ?? '' }}"
       data-template='<div class="popover bg-primary-500 border-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-transparent"></h3><div class="popover-body text-white text-center"></div></div>'
       data-original-title="{{ $analogous_sensor->sensor->pre_text ?? '' }}"
       @endif
       {!! makeLinkRemote() !!}
       class="d-block  rounded-plus mb-1 px-2 py-1 text-center"
       id="d_{{$analogous_sensor->id}}_{{$analogous_sensor->sensor->id}}">
@else
    <div
        class="d-block  rounded-plus mb-1 px-2 py-1 text-center"
        @if($analogous_sensor->sensor->pre_text != '')
        data-toggle="popover"
        data-trigger="hover"
        data-placement="top"
        title=""
        data-content="{{ $analogous_sensor->sensor->max_value }} {{ optional(optional($disposition)->unit)->name }}  {{ $analogous_sensor->sensor->post_text ?? '' }}"
        data-template='<div class="popover bg-primary-500 border-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-transparent"></h3><div class="popover-body text-white text-center"></div></div>'
        data-original-title="{{ $analogous_sensor->sensor->pre_text ?? '' }}"
        @endif
        id="d_{{$analogous_sensor->id}}_{{$analogous_sensor->sensor->id}}">
@endif
        <h2 class=" mb-0  @if($off) text-muted @else text-{{ $color }} @endif">
            @if(!is_numeric((str_replace(',','.',$data))))
                <span class="font-weight-bolder " style=" font-size: 0.9em !important;">{{ $data }}</span>
            @else
                <span class="font-weight-bolder " style=" font-size: 0.9em !important;">{{ $data }}</span>
                <span class="fs-nano text-dark">{{ strtoupper(optional(optional($disposition)->unit)->name) }}</span>
            @endif
        </h2>
        <span  class="font-weight-bold text-dark  fs-nano">{{ $analogous_sensor->sensor->name}}</span>
        @if($analogous_sensor->sensor->pre_text != '')
            <span  class="font-weight-bold text-muted hidden-sm-up  fs-nano"> ({{ $analogous_sensor->sensor->pre_text ?? '' }} {{ number_format($analogous_sensor->sensor->max_value,',','') }} {{ optional(optional($disposition)->unit)->name }} {{ $analogous_sensor->sensor->post_text ?? '' }})</span>
        @endif
@if($analogous_sensor->no_chart_needed != 1)
    </a>
@else
    </div>
@endif
