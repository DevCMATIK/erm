<script>
    $(document).ready(function(){
        let form = $("{{ $form }}");
        form.on('submit',function(e) {
            e.preventDefault();
            $('{{ $form }} .alert').remove();
            $.ajax({
                url     : '{{ $url }}',
                type    : 'POST',
                data    : form.serialize(),
                dataType: "json",
                success : function ( json )
                {
                    $('.form-control').removeClass('is-invalid').addClass('is-valid');
                    $('.error-tooltip').remove();
                    toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                    form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                    {!! $onSuccess !!}
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
