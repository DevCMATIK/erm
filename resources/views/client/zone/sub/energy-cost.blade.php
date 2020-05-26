@extends('layouts.app')
@section('page-title','Valor/Hora de energia para cada sub Zona')
@section('page-icon','database')

@section('page-content')
    <form class="" role="form"  id="sub-zones-form">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">

                        Sub zonas disponibles
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Zona</th>
                                <th>Sub Zona</th>
                                <th>Costo/Hora Energya</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sub_zones as $sub_zone)
                                <tr>
                                    <td>{{ $sub_zone->zone->name}}</td>
                                    <td>{{ $sub_zone->name }}</td>
                                    <td>
                                        <input type="text" class="form-control" name="energy_costs[]" value="{{ optional($sub_zone->energy_cost)->hour_cost }}">

                                        <input type="hidden" name="sub_zones[]" value="{{ $sub_zone->id }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('page-extra-scripts')
    <script>

        $(document).ready(function()
        {
            let form = $("#sub-zones-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#sub-zones-form .alert').remove();
                $.ajax({
                    url     : '/subZoneHourCosts',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/subZoneHourCosts';
                    },
                    error   : function ( response )
                    {
                        let messages = jQuery.parseJSON(response.responseText);
                        if(response.status === 401){
                            if(messages.error){
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>"+messages.error+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }else{
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>No se pudo completar la acción.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }
                        }else if( response.status === 500) {
                            form.prepend("<div class='alert alert-danger alert-dismissible fade show'>Ha Ocurrido en el servidor.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        }else{
                            handleFormErrors(messages);
                        }
                    }
                })
            });



        });

    </script>
@endsection
