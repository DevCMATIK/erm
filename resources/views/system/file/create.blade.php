@extends('components.modals.form-modal')
@section('modal-title','Subir Archivo')
@section('modal-content')
    {!! includeCss(['plugins/dropzone/dropzone.css']) !!}
    {!! includeScript(['plugins/dropzone/dropzone.js']) !!}
    <form class="dropzone" action="/file/upload"  enctype="multipart/form-data" id="dropzoneForm">
        @csrf
        <input type="hidden" value="{{ $table }}" name="referenced_table">
        <input type="hidden" value="{{ $id }}" name="referenced_id">
        <input type="hidden" value="{{ $unique }}" name="is_unique">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#dropzoneForm").dropzone({
                method: 'POST',
                queuecomplete : function(){
                    toastr.success('Se han cargado los archivos.');
                    location.reload()
                },
                error : function (response){
                    var messages = jQuery.parseJSON(response.responseText);
                    if(response.status == 401){
                        if(messages.error){
                            toastr.error(messages.error,'Error!');
                        }else{
                            toastr.error('Error al cargar los archivos','Error!');
                        }
                    }
                }
            });
        });
    </script>
@endsection
@section('no-submit','Si no desea cargar archivos presione')
@section('modal-width','70')
