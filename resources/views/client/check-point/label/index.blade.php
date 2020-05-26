@extends('layouts.app-navbar')
@section('page-title','Nombres de puntos de control para home')
@section('page-icon','database')

@section('page-content')
    <form class="" role="form"  id="check-point-labels-form">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        Puntos de control disponibles
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Zona</th>
                                <th>Sub Zona</th>
                                <th>Punto de Control</th>
                                <th>Dispositivo</th>
                                <th>Nombre a mostrar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->sortBy('position') as $row)
                                <tr>
                                    <td>{{ $row['zone'] }}</td>
                                    <td>{{ $row['sub_zone'] }}</td>
                                    <td>{{ $row['check_point'] }}</td>
                                    <td>{{ $row['device_name'] }}</td>
                                    <td>
                                        <input type="text" class="form-control" name="labels[]" value="{{ $row['label'] ?? $row['check_point'] }}">
                                        <input type="hidden" name="check_points[]" value="{{ $row['check_point_id'] }}">
                                        <input type="hidden" name="devices[]" value="{{ $row['device_id'] }}">
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
            let form = $("#check-point-labels-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#check-point-labels-form .alert').remove();
                $.ajax({
                    url     : '/check-point-labels',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/check-point-labels';
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
