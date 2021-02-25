@if($analogous_sensor->no_chart_needed != 1)
    <a href="/getDataAsChart/{{ $analogous_sensor->sensor->device_id }}/{{ $analogous_sensor->sensor->id }}"
       {!! makeLinkRemote() !!}
       class="d-block  rounded-plus mb-1 px-2 py-1 text-center has-popover"
       id="d_{{$analogous_sensor->id}}_{{$analogous_sensor->sensor->id}}">
@else
    <div
        class="d-block  rounded-plus mb-1 px-2 py-1 text-center has-popover"

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
            <span  class="font-weight-bold text-muted   fs-nano"> ({{ $analogous_sensor->sensor->pre_text ?? '' }} {{ number_format($analogous_sensor->sensor->max_value,1,',','') }} {{ optional(optional($disposition)->unit)->name }} {{ $analogous_sensor->sensor->post_text ?? '' }})</span>
        @endif
@if($analogous_sensor->no_chart_needed != 1)
    </a>
@else
    </div>
@endif

<script>
    $(function(){
        $('body').popover(
            {
                selector: '.has-popover'
            });
    })
</script>
