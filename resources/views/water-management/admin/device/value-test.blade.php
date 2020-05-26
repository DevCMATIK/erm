@extends('components.modals.form-modal')
@section('modal-title','Test Variable')
@section('modal-content')
    <h5>Sensor: {{ $sensor->name }} </h5>
    <p>Full Address: {{ $sensor->full_address }} grd_id : {{ $sensor->device->internal_id }}</p>
    <hr>
    <div class="row">
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3 ">ingMin</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" >{{ $value['ingMin'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3">ingMax</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" >{{ $value['ingMax'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3 ">scaleMin</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" >{{ $value['scaleMin'] ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 my-1">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-6 py-3 pl-3">scaleMax</div>
                        <div class="col-6  text-center py-3 bg-primary text-white rounded-plus border-bottom-left-radius-0 border-top-left-radius-0" >{{ $value['scaleMax'] ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <h5><strong>Valor Leído</strong><br>{{ $value['valorReport'] }}</h5>
                        </div>
                        <div class="col-9">
                            <h5><strong>Formula Usada</strong><br>{{ $value['formula'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center fs-xxl p-6 text-white bg-primary">
            {{ $value['data'] }} {{ optional(optional($disposition)->unit)->name }}
        </div>
    </div>
@endsection
@section('no-submit','.')
