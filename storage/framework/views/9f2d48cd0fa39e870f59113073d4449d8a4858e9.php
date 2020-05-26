<?php

    if(isset($analogous)) {
         $address = strtolower($analogous->sensor->address->name."".$analogous->sensor->address_number);
    if(!$disposition = $analogous->sensor->dispositions()->where('id',$analogous->sensor->default_disposition)->first()) {
        $disposition = $analogous->sensor->dispositions()->first();
    }
    if($disposition) {
         $valorReport = $analogous->sensor->device->report->$address; // 0, 400
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
        $percentaje = number_format((float)($data*100/$analogous->sensor->max_value), (int)$disposition->precision);
        if(isset($digital) && $digital) {
             $digitalAddress = strtolower($digital->sensor->address->name."".$digital->sensor->address_number);
             if($digitalValue = $digital->sensor->device->report->$digitalAddress == 1) {
                $digital_label = $digital->sensor->label->on_label;
            } else {
                $digital_label = $digital->sensor->label->off_label;
            }
        }
    }
    }


?>
<?php if(isset($analogous)): ?>
<?php if($disposition): ?>
<?php echo $__env->make('water-management.dashboard.control.html.column', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <div class="alert alert-info">No ha seleccionado disposicion por defecto.</div>
<?php endif; ?>
    <?php endif; ?>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/column.blade.php ENDPATH**/ ?>