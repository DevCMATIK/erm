@php



    $value = array();
        foreach($s as $sensor) {
            if(isset($sensor)) {
                 $address = $sensor->full_address;
                if(!$disposition = $sensor->selected_disposition()->first()){
                    $disposition = $sensor->dispositions()->first();
                }
                if($disposition) {

                if($sensor->device->from_bio === 1) {
                 $valorReport =  DB::connection('bioseguridad')->table('reports')
                    ->where('grd_id',optional($sensor->device)->internal_id)
                    ->first()->{$address};
                 } else {
                        $valorReport = $sensor->device->report->$address; // 0, 400
                 }
                if($sensor->fix_values_out_of_range === 1) {

                    if($valorReport < $disposition->scale_min) {
                        $valorReport = $disposition->scale_min;
                    } else {
                        if($valorReport > $disposition->scale_max) {
                            $valorReport = $disposition->scale_max;
                        }
                    }

                }
                $ingMin = $disposition->sensor_min;
                $ingMax = $disposition->sensor_max;
                $escalaMin = $disposition->scale_min;
                $escalaMax = $disposition->scale_max;
                if($escalaMin == null && $escalaMax == null) {
                    $data = ($ingMin * $valorReport) + $ingMax;
                } else {
                    $f1 = $ingMax - $ingMin;
                    $f2 = $escalaMax - $escalaMin;
                    $f3 = $valorReport - $escalaMin;
                    if($f2 == 0) {
                        $data = ((0)*($f3)) + $ingMin ;
                    } else {
                        $data = (($f1/$f2)*($f3)) + $ingMin ;
                    }
                }
                $interpreters = $sensor->type->interpreters;
                if(count($interpreters) > 0) {
                    if($interpreter = $interpreters->where('value',(int) $data)->first()) {
                        $data = $interpreter->name;
                    }
                }

                $color = 'success';
                $ranges = $sensor->ranges;
                if (count($ranges) > 0) {
                    foreach($ranges as $range) {
                        if((float)$data >= $range->min && (float)$data <= $range->max) {
                            $color = $range->color;
                        }
                    }
                }

                $sensor_name = $sensor->name;
                $unit = $disposition->unit->name;
            }
            }
                array_push($value,$data);
            }




    if($function == 'sum') {
         $value = number_format(collect($value)->sum(),$disposition->precision,',','');
    } else {
        $value = number_format(collect($value)->avg(),$disposition->precision,',','');
    }


@endphp
@if(isset($value))
    @if($disposition)
        @include('water-management.dashboard.views.electric.control.analogous')
    @else
        <div class="alert alert-info m-0">
            No ha seleccionado disposicion por defecto.
        </div>
    @endif
@endif
