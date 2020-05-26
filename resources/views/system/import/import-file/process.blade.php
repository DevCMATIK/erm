<div id="div-progress">


</div>
<div id="myCode"></div>
<hr class="simple">
<a class="btn btn-primary text-white continuar" onClick="continuar();"><i class="fa fa-play"></i> Continuar</a>
<a class="btn btn-primary text-white begin" onClick="comenzar();"><i class="fa fa-play"></i> Comenzar</a>
<a class="btn btn-warning text-white pause" onClick="pausar();"><i class="fa fa-pause"></i> Pausar</a>
<a class="btn btn-info text-white finalizar" onClick="finalizar();"><i class="fa fa-check"></i> Finalizar</a>
<input type="hidden" id="pausa" value="0">
<script>
    $('document').ready(function(){
        comenzar();
    });
    $('.pause').hide();
    $('.spin').hide();
    $('.continuar').hide();
    $('.finalizar').hide();

    function procesar(){
        let pausa = $('#pausa').val();
        if(pausa == 0){
            $.ajax({
                type : "GET",
                url : '/importFileProcess/{{ $importFile->import->slug }}/{{ $importFile->id }}',
                dataType: "json",
                success: function(response){

                    if(response.msg == 'OK') {
                        progressBar();
                        procesar();
                    }else {
                        finalizar();
                    }


                },
                error : function(response){
                    if(response.status == 401){
                        var messages = jQuery.parseJSON(response.responseText);
                        if(messages.error){
                            $('#import-content').html('<div class="alert alert-danger"><h5><strong>Error.</strong></h5><p>'+messages.error+'</p></div>');
                            $('#import-content').after('<a href="/importFile/{{ $importFile->import->slug }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver</a>');
                        }else{
                            toastr.error('Error al procesar la planilla','Error!');
                        }
                    }

                    if(response.status == 500) {
                        var messages = jQuery.parseJSON(response.responseText);
                        if(messages.message == 'Maximum execution time of 60 seconds exceeded'){
                            progressBar();
                            procesar();
                        }

                        if(messages.message == 'Call to a member function update() on null') {
                            progressBar();
                            procesar();
                        }
                    }
                }
            });
        }

    }
    function pausar(){
        $('#pausa').val(1);
        $('.pause').hide();
        $('.continuar').show();

    }
    function continuar(){
        $('#pausa').val(0);
        $('.pause').show();
        $('.continuar').hide();
        procesar();
    }
    function comenzar(){
        $('#pausa').val(0);
        $('.pause').show();
        $('.begin').hide();
        procesar();
    }

    function progressBar()
    {
        $.ajax({
            type : "GET",
            url : "/importFile/progressBar/{{ $importFile->id }}",
            contentType: false,
            processData: false,
            success: function(data){
                $('#div-progress').html(data);
            },
            error : function(data){
                console.log(data.responseText);
                var obj = jQuery.parseJSON(data.responseText);

                if (obj.error) {
                }
            }
        });
    }

    progressBar();

    function finalizar(){
        toastr.success('Proceso Finalizado','Exito!');
        location.href = "/importFile/{{ $importFile->import->slug }}";
    }
</script>



