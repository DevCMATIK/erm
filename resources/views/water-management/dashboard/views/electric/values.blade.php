@foreach($sensors as $type)
    @foreach($type->groupBy('name') as $key => $s)
        @include('water-management.dashboard.views.electric.val',[
            'class' => $class,
            'function' => $function
        ])
    @endforeach
@endforeach
