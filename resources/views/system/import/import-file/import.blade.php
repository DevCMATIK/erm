@extends('layouts.app')
@section('page-title','Importando: '.$importFile->file)
@section('page-icon','file-excel-o')
@section('page-extra-scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                url     : '/importTemps/{{ $importFile->id }}',
                type    : 'GET',
                dataType: "json",
                success : function ( json )
                {
                    showProcesar();
                },
                error   : function ( response )
                {
                    if(response.status == 401){
                        let messages = jQuery.parseJSON(response.responseText);
                        if(messages.error){
                            $('#import-content').html('<div class="alert alert-danger"><h5><strong>Error.</strong></h5><p>'+messages.error+'</p></div>');
                            $('#import-content').after('<a href="/importFile/{{ $importFile->import->slug }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver</a>');
                        }else{
                            toastr.error('Error al procesar la planilla','Error!');
                        }
                    }
                }
            });
        });

        function showProcesar(){
            $.get('/importFile/process/{{ $importFile->id }}', function(data){
                $('#import-content').html(data);
            });
        }
    </script>
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card  ">
                <div class="card-header bg-primary text-white">
                    Cargar Planilla: {{ $importFile->file }}
                </div>
                <div class="card-body" id="import-content">
                    <h5><i class="fa fa-spinner fa-spin"></i> Checking file Status...</h5>
                </div>
            </div>
        </div>
    </div>

@endsection


