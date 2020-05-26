@if(isset($subZone->elements) && count ($subZone->elements) > 0)
    @forelse($subZone->elements()->where('column',$i)->first()->sub_elements()->get()->groupBy(function($q){
        return $q->check_point_id;
    }) as $sub_element)
        <ul id="device_{{ $sub_element->first()->check_point_id }}" class="list-group">
            <li class="list-group-item cursor-move" style="width: 100%">
                {{ $sub_element->first()->check_point->name }}
                <a href="javascript:void(0);" onclick="removeSubElement({{ $sub_element->first()->id }})" class="float-right text-danger"><i class="fas fa-times fa-1x"></i></a>
                <a href="/subElementConfig/{{ $sub_element->first()->id }}" {!! makeLinkRemote() !!} class="float-right mx-2"><i class="fas fa-pen fa-1x"></i></a>
            </li>
        </ul>
    @empty
    @endforelse
@endif

<script>
    function removeSubElement(sub_element)
    {
        Swal.fire({
            title: "Eliminar Punto de Control",
            text: "Si lo elimina perdera toda la configuracion para de este para la sub zona",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar"
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "GET",
                    url: '/removeSubElement/'+sub_element,
                    success: function success(data) {


                            toastr.success("Registro eliminado correctamente.");
                            Swal.close();
                            location.reload();

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
            } else {
                Swal.close();
            }
        });
    }
</script>
