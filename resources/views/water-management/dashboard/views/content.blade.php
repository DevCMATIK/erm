@php
    $check_points =  $subZone->check_points->implode('id',',');

@endphp
<input type="hidden" id="check_points" value="{{ $check_points }}">
@foreach($subZone->elements as $element)

    @include('water-management.dashboard.partials.element', ['options' => [
		'digital' => 'outputs-as-states'
	]])
@endforeach
<script>
    $(document).ready(function()
    {
        $('.onoffswitch input[type="checkbox"]').click(function(e){
            let element = $(this);
            let order;
            e.preventDefault();
            if(element.prop("checked") === true){
                order = 1;
            }
            else if(element.prop("checked") === false){
                order = 0;
            }
            confirmAction('Realmente desea ejecutar el comando?','', sendCommand);

            function sendCommand()
            {
                if(order === 0 ) {
                    element.prop('checked',false);
                } else {
                    element.prop('checked',true);
                }
                $.get('/sendCommand', {
                        element : element.attr('id'),
                        order : order
                    } ,function() {
                        toastr.success('Comando ejecutado');
                    }
                )
            }
        });
    });

</script>
