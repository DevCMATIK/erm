@extends('layouts.app')
@section('page-title','Crear nuevo email tipo')
@section('page-icon','envelope')
@section('more-css')
    {!! includeCss('plugins/summernote/summernote.css') !!}
@endsection
@section('more-scripts')
    {!! includeScript('plugins/summernote/summernote.js') !!}
@endsection
@section('page-content')
    <div class="row">
        <div class="col-xl-12">
            <div class="float-right">
                {!! makeLink('/mails','Volver a Correos','fa-arrow-left' ,'btn-primary','btn-sm') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Formulario de creacion
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form  role="form"  id="mail-form">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control"  name="name">
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label">Asunto</label>
                                        <input type="text" class="form-control"  name="subject">
                                    </div>
                                    <div class="col-2">
                                        <label class="custom-control custom-checkbox">
                                            <label class="form-label">Visibilidad</label><br>
                                            <input type="checkbox" class="custom-control-input" value="1" name="share_with_all">
                                            <span class="custom-control-label">Todos</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Encabezado</label>
                                <textarea name="header" class="js-summernote" id="header"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cuerpo del correo</label>
                                <textarea name="body" class="js-summernote" id="body"></textarea>
                            </div>


                            <div class="form-group my-2">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col table-responsive">
                                <h5>Listado de conectores</h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Descripcion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attachables as $attachable)
                                            <tr>
                                                <td>{{ $attachable->code }}</td>
                                                <td>{{ $attachable->name }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">No ha configurado los conectores</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-extra-scripts')
    <script>

        $(document).ready(function()
        {
            let form = $("#mail-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#mail-form .alert').remove();
                $.ajax({
                    url     : '/mails',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/mails';
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
            //init default
            $('.js-summernote').summernote(
                {
                    height: 200,
                    tabsize: 2,
                    placeholder: "Type here...",
                    dialogsFade: true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                            ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    hint:
                        {
                            mentions: {!!   json_encode($attachables->pluck('code')->toArray()) !!},
                            match: /\B@(\w*)$/,
                            search: function(keyword, callback)
                            {
                                callback($.grep(this.mentions, function(item)
                                {
                                    return item.indexOf(keyword) == 0;
                                }));
                            },
                            content: function(item)
                            {
                                return ' '+item+' ';
                            }
                        }
                });


        });

    </script>
    @endsection





