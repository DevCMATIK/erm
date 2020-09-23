@if($digital_sensor->sensor->address->slug == 'o' && $digital_sensor->is_not_an_output != 1)
    @php
        $address = $digital_sensor->sensor->full_address;
    @endphp
    @if(Sentinel::getUser()->hasAccess('dashboard.control-mode'))
        @include('water-management.dashboard.control.html.digital-output')
    @else
        @php
            $address = $digital_sensor->sensor->full_address;
             if($digital_sensor->sensor->device->from_bio === 1) {
                 $valorReport =  DB::connection('bioseguridad')->table('reports')
                    ->where('grd_id',optional($digital_sensor->sensor->device)->internal_id)
                    ->first()->{$address};
         } else {
                $valorReport = $digital_sensor->sensor->device->report->$address; // 0, 400
         }
			if($valorReport == 1) {
				$data = $digital_sensor->sensor->label->on_label;
				$class = 'success';
			} else {
				$data = $digital_sensor->sensor->label->off_label;
				$class = 'secondary';
			}
        @endphp
        @include('water-management.dashboard.control.html.digital-input',['is_output' => true])
    @endif
@else
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
    @include('water-management.dashboard.control.html.digital-input',['is_output' => false])
@endif


