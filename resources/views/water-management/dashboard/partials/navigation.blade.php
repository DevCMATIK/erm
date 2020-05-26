<div class="modal fade js-modal-messenger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-left modal-sm">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">Puntos de Control</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">
                <div class="row">
                    <div class="col">
                        <ul class="list-group w-100 rounded-0" >
                            @foreach($subZone->sub_elements->groupBy(function($q){
                           return $q->check_point_id;
                       }) as $sub)

                                @if($sub->first()->check_point_id == $check_point)
                                    <a class=" cursor-pointer list-group-item active text-white my-1"  href="/dashboard/detail/{{ $sub->first()->check_point->id }}"  >{{ $sub->first()->check_point->name }}</a>
                                @else
                                    <a class="cursor-pointer list-group-item my-1 text-dark"   href="/dashboard/detail/{{ $sub->first()->check_point->id }}"  >{{ $sub->first()->check_point->name }}</a>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade js-modal-kpi" tabindex="-1" role="dialog" id="modal-kpi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-md">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">KPI</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">
                @if ($flow || $totalizer || $costs)
                    @if($flow)
                        <div class="row mb-4" id="kpi-flow-content">
                            @include('water-management.dashboard.partials.kpi.flow-kpi')
                        </div>
                    @endif
                    @if($totalizer)
                        <div class="row mt-3 mb-4" id="kpi-totalizer-content">
                            @include('water-management.dashboard.partials.kpi.totalizer-kpi')
                        </div>
                    @endif
                    @if($costs)
                            @foreach($costs as $kpi)
                                <div class="row mb-4">
                                    @include('water-management.dashboard.partials.kpi.cost-kpi')
                                </div>

                            @endforeach
                    @endif
                @else
                    <div class="alert alert-info">
                        El Punto de control no posee KPI asociados
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>


