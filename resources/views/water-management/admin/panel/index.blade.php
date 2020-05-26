@extends('layouts.app')
@section('page-title','Administrar Dashboards')
@section('page-icon','cog')
@section('page-content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xl-6">
                                <label class="form-label">Zonas</label>
                                <select class="form-control"  id="zone" onchange="getSubZones()">
                                    <option value="">Seleccione...</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-6" id="SubZoneContainer">
                                <label class="form-label">Sub Zonas</label>
                                <select class="form-control"  id="sub_zona">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body" id="adminContainer">
                    <div class="alert alert-info">
                        Seleccione sub Zona para administrar los dispositivos.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getSubZones() {
            let zone = $('#zone').val();
            $.get('/getSubZonesCombo/'+zone, function(data){
                $('#SubZoneContainer').html(data);
            });
        }

        function getDataFromSubZone() {
            let subZone = $('#sub_zone').val();
            location.href = '/admin-panel/'+subZone;
        }
    </script>
@endsection
