<div class="row">
    @forelse($sub_columns = optional($subColumns->where('sub_element',$sub_element->first()->id)->first())['sub_columns'] as $column => $key)
        <div class="col-12 col-12 col-sm-12 col-md-12 col-xl-12">
            <h5>{{ $sub_element->first()->element->name }}</h5>

            <div class="row">
                @foreach($sub_element as $se)
                    @foreach($se->analogous_sensors->where('use_as_chart','<>',1)->where('show_in_dashboard',1) as $analogous_sensor)
                         <div class=" col-sm-12 col-md-12 col-xl-12">
                             @include('water-management.dashboard.control.analogous-electric',['analogous_sensor' => $analogous_sensor])
                         </div>
                      @endforeach
                 @endforeach
            </div>
        </div>
            @empty
                <div class="col-xl-12">
                    <div class="alert alert-info">
                        No hay sensores disponibles.
                    </div>
                </div>
                <script>$('#sub_element_{{ $sub_element->first()->id }}').remove()</script>
            @endforelse
</div>
