@foreach($subZone->elements->filter(function($item){
			   return (count($item->sub_elements->filter(function($sub_element){
					   return count($sub_element->digital_sensors->filter(function($digital_sensor) {
						   return ($digital_sensor->sensor->address->slug == 'o' && $digital_sensor->use_as_digital_chart == 0 && $digital_sensor->is_not_an_output != 1);
					   })) > 0;
				   })) > 0);
		   }) as $element)

    @include('water-management.dashboard.partials.element', ['options' => [
		'digital' => 'only-outputs'
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
