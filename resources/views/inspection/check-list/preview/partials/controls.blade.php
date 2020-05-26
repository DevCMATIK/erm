@foreach($sub->controls as $control)
    @switch($control->type)
        @case('text')
            @include('inspection.check-list.preview.partials.controls.text')
        @break
        @case('radio')
            @include('inspection.check-list.preview.partials.controls.radio')
        @break
        @case('check')
            @include('inspection.check-list.preview.partials.controls.check')
        @break
        @case('combo')
            @include('inspection.check-list.preview.partials.controls.combo')
        @break
    @endswitch
@endforeach
