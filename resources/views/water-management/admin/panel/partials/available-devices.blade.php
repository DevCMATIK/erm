<div class="row">
    <div  class="col-xl-2" id="devices-list">
        @forelse($subZone->check_points as $check_point)

                @if(!$subZone->sub_elements->contains('check_point_id',$check_point->id))
                    <ul id="device_{{ $check_point->id }}" class="list-group">
                        <li class="list-group-item cursor-move" style="width: 100%">
                            {{ $check_point->name }}
                        </li>
                    </ul>
                @endif

        @empty
            <div class="alert alert-danger">
                No ha cargado puntos de control a la sub zona.
            </div>
        @endforelse

    </div>
</div>

