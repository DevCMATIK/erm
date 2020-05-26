@if(isset($options) && $options['digital'] == 'outputs-as-states')
    @php
        $address = $digital_sensor->sensor->full_address;
		if($digital_sensor->sensor->device->report->$address == 1) {
			$data = $digital_sensor->sensor->label->on_label;
			$class = 'success';
		} else {
			$data = $digital_sensor->sensor->label->off_label;
			$class = 'secondary';
		}

		if ($digital_sensor->sensor->address->slug == 'o') {
            $is_output = true;
            if($class == 'success') {
                $class = 'primary';
            } else {
                 $class = 'gray-400';
            }
		} else {
            $is_output = false;
		}
    @endphp
@else
    @if($digital_sensor->sensor->address->slug == 'i' || $digital_sensor->is_not_an_output == 1)
        @php
            $address = $digital_sensor->sensor->full_address;
			if($digital_sensor->sensor->device->report->$address == 1) {
				$data = $digital_sensor->sensor->label->on_label;
				$class = 'success';
			} else {
				$data = $digital_sensor->sensor->label->off_label;
				$class = 'secondary';
			}
            $is_output = false;
        @endphp
    @endif
@endif
@if(Sentinel::getUser()->hasAccess('dashboard.control-mode') && $is_output === true)
    @include('water-management.dashboard.control.digital-output')
@else
    @include('water-management.dashboard.control.html.digital-input',['is_output' => $is_output])
@endif
