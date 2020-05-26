<?php
    if(isset($analogous_sensor)) {
         $address = $analogous_sensor->sensor->full_address;
    if(!$disposition = $analogous_sensor->sensor->dispositions()->where('id',$analogous_sensor->sensor->default_disposition)->first()){
        $disposition = $analogous_sensor->sensor->dispositions()->first();
    }
    if($disposition) {

        $valorReport = $analogous_sensor->sensor->device->report->$address; // 0, 400

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
        $data = number_format($data,$disposition->precision,',','');
        $color = 'success';
        $ranges = $analogous_sensor->sensor->ranges;
        if (count($ranges) > 0) {
            foreach($ranges as $range) {
                if((float)$data >= $range->min && (float)$data <= $range->max) {
                    $color = $range->color;
                }
            }
        }
    }
    }

?>
<?php if(isset($analogous_sensor)): ?>
    <?php if($disposition): ?>
        <?php echo $__env->make('water-management.dashboard.control.html.analogous-electric', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <div class="alert alert-info">
            No ha seleccionado disposicion por defecto.
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/analogous-electric.blade.php ENDPATH**/ ?>