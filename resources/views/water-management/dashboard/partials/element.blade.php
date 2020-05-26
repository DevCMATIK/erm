<div class="col-xl-{{ 12 / $columns }}" id="element_{{ $element->id }}">

    @foreach($element->sub_elements->groupBy(function($q){
        return $q->check_point_id;
    }) as $sub_element)
        @include('water-management.dashboard.partials.sub-element')
    @endforeach

</div>
