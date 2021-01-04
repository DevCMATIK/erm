<?php
    if(isset($analogous_sensor)) {
         $address = $analogous_sensor->sensor->full_address;
    if(!$disposition = $analogous_sensor->sensor->dispositions()->where('id',$analogous_sensor->sensor->default_disposition)->first()){
        $disposition = $analogous_sensor->sensor->dispositions()->first();
    }
    if($disposition) {

         if($analogous_sensor->sensor->device->from_bio === 1) {
                 $valorReport =  DB::connection('bioseguridad')->table('reports')
                    ->where('grd_id',optional($analogous_sensor->sensor->device)->internal_id)
                    ->first()->{$address};
            } else {
                $valorReport = $analogous_sensor->sensor->device->report->$address; // 0, 400
            }
        if($analogous_sensor->sensor->fix_values_out_of_range === 1) {

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


        $interpreters = $analogous_sensor->sensor->type->interpreters;
            if(count($interpreters) > 0) {
                if($interpreter = $interpreters->where('value',(int) $data)->first()) {
                    $data = $interpreter->name;
                } else {
                    $data = number_format($data,$disposition->precision,',','');
                }

            } else {
                  $data = number_format($data,$disposition->precision,',','');
            }


        $color = 'success';

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
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/control/analogous-electric.blade.php ENDPATH**/ ?>