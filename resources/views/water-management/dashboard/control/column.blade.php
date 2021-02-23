@php

    if(isset($analogous)) {
         $address = strtolower($analogous->sensor->address->name."".$analogous->sensor->address_number);
    if(!$disposition = $analogous->sensor->dispositions()->where('id',$analogous->sensor->default_disposition)->first()) {
        $disposition = $analogous->sensor->dispositions()->first();
    }
    if($disposition) {
        if($analogous->sensor->device->from_bio === 1) {
                 $valorReport =  DB::connection('bioseguridad')->table('reports')
                    ->where('grd_id',optional($analogous_sensor->sensor->device)->internal_id)
                    ->first()->{$address};
            } else {
                if($analogous->sensor->device->from_dpl === 1) {
                     $valorReport =  DB::connection('dpl')->table('reports')
                    ->where('grd_id',optional($analogous_sensor->sensor->device)->internal_id)
                    ->first()->{$address};
                } else {
                    $valorReport = $analogous->sensor->device->report->$address; // 0, 400
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
        $color = 'success';
        $ranges = $analogous->sensor->ranges;
        if (count($ranges) > 0) {

            foreach($ranges as $range) {
                if((float)$data >= $range->min && (float)$data <= $range->max) {
                    $color = $range->color;

                }
            }
        }
        $max = ($analogous->sensor->max_value < 0)?($analogous->sensor->max_value * -1):$analogous->sensor->max_value;
        $fill = ($data < 0)?($data*-1):$data;
        $percentaje = number_format((float)($fill*100/$max), (int)$disposition->precision);
        if(isset($digital) && $digital) {
             $digitalAddress = strtolower($digital->sensor->address->name."".$digital->sensor->address_number);
             if($digital->sensor->device->from_bio === 1) {
                    $vall =  DB::connection('bioseguridad')
                        ->table('reports')
                        ->where('grd_id',$digital->sensor->device->internal_id)
                        ->first()->{$digitalAddress} ?? null;
                } else {
                   if($digital->sensor->device->from_dpl === 1) {
                        $vall = DB::connection('dpl')
                            ->table('reports')
                            ->where('grd_id',$digital->sensor->device->internal_id)
                            ->first()->{$digitalAddress} ?? null;
                    } else {
                       $vall = $digital->sensor->device->report->{$digitalAddress};
                    }
                }

             if($digitalValue = $vall == 1) {
                $digital_label = $digital->sensor->label->on_label;
            } else {
                $digital_label = $digital->sensor->label->off_label;
            }
        }
    }
    }


@endphp
@if(isset($analogous))
@if($disposition)
@include('water-management.dashboard.control.html.column')
@else
    <div class="alert alert-info">No ha seleccionado disposicion por defecto.</div>
@endif
    @endif
