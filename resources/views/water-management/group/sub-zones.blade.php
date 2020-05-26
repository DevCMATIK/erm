@extends('components.modals.form-modal')
@section('modal-title','Grupo: '.$group->name)
@section('modal-content')

    <form action=""  role="form"  id="group-sub-zones-form">
        @csrf
        <h5>Sub Zonas Asignadas al Grupo</h5>
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
                            <input type="checkbox" class="custom-control-input main-control" name="{{ $zone->id }}" id="{{ $zone->slug  }}" value="{{ $zone->slug  }}">
                            <label class="custom-control-label" for="{{ $zone->slug }}">{{ $zone->name }}</label>
                        </div>
                    <td>
                        @foreach($zone->sub_zones as $sub_zone)
                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="{{ $zone->slug  }} custom-control-input"
                                               name="sub_zones[]"
                                               id="{{ $zone->slug .$sub_zone->id }}"
                                               value="{{ $sub_zone->id }}"
                                               @if($group->sub_zones->where('id',$sub_zone->id)->first())
                                               checked
                                            @endif
                                        >
                                        <label class="custom-control-label" for="{{ $zone->slug.$sub_zone->id  }}">{{ $sub_zone->name  }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </form>
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
@endsection
@section('modal-validation')

    {!!  makeValidation('#group-sub-zones-form','/groupSubZones/'.$group->id, "closeModal();") !!}
@endsection
@section('modal-width','60')

