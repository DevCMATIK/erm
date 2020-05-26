@if($user->production_areas->count() > 0)
    <h5>Sub Zonas Asignadas a usuario</h5>
    <form class="" role="form"  id="user-sub-zones-form">
        @csrf
        <div class="card-datatable">
            <table class="table table-bordered table-striped" id="table-generated">
                <thead>
                <tr>
                    <th>Zona</th>
                    <th>Sub Zonas</th>
                </tr>
                </thead>
                <tbody>
                @foreach($zones as $zone)
                    <tr>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input main-control" name="{{ $zone['slug'] }}" id="{{ $zone['slug']  }}" value="{{ $zone['slug']  }}">
                                <label class="custom-control-label" for="{{ $zone['slug'] }}">{{ $zone['name']  }}</label>
                            </div>
                        <td>
                            @foreach($sub_zones->where('zone_id',$zone['id']) as $sub_zone)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="{{ $zone['slug']  }} custom-control-input"
                                                   name="sub_zones[]"
                                                   id="{{ $zone['slug'] .$sub_zone['id']  }}"
                                                   value="{{ $sub_zone['id']  }}"
                                                   @if($user->sub_zones->where('id',$sub_zone['id'])->first())
                                                        checked
                                                       @endif
                                            >
                                            <label class="custom-control-label" for="{{ $zone['slug'].$sub_zone['id']  }}">{{ $sub_zone['name']  }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"> Guardar SubZonas</button>
        </div>
    <script>
        $('.main-control').change(function() {
            var id = this.id;
            if($(this).is(":checked")) {

                $('.'+id).prop('checked',true);
            }else {
                $('.'+id).prop('checked',false);
            }
            //'unchecked' event code
        });
    </script>
    </form>
    {!!  makeValidation('#user-sub-zones-form','/userSubZones/'.$user->id, "") !!}
@else
    <div class="alert alert-info">
        No ha asignado areas de produccion al usuario, seleccione almenos una para poder administrar sus zonas
    </div>
@endif
