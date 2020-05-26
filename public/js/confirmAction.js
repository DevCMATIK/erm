function confirmAction(text,url,func)
{
    Swal.fire({
        title: "Favor, Confirmar acción.",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, ejecutar Acción."
    }).then(function (result) {
        if (result.value) {
            if(func && func !== 'refresh') {
                func();
            } else {
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function success(data) {

                        toastr.success('Completado exitosamente.');

                        if(func === 'refresh') {
                            location.reload();
                        }
                    },
                    error: function error(data) {
                        console.log(data.responseText);
                        var obj = jQuery.parseJSON(data.responseText);

                        if (obj.error) {
                            toastr.error(obj.error);
                            Swal.close();
                        }
                    }
                });
            }

        } else {
            Swal.close();
        }
    });
}
