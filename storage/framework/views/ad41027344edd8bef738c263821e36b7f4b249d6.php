<?php if($digital_sensor->sensor->address->slug == 'o' && $digital_sensor->is_not_an_output != 1): ?>
    <?php
        $address = $digital_sensor->sensor->full_address;
    ?>
    <?php if(Sentinel::getUser()->hasAccess('dashboard.control-mode')): ?>
        <?php echo $__env->make('water-management.dashboard.control.html.digital-output', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php
            $address = $digital_sensor->sensor->full_address;
			if($digital_sensor->sensor->device->report->$address == 1) {
				$data = $digital_sensor->sensor->label->on_label;
				$class = 'success';
			} else {
				$data = $digital_sensor->sensor->label->off_label;
				$class = 'secondary';
			}
        ?>
        <?php echo $__env->make('water-management.dashboard.control.html.digital-input',['is_output' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php else: ?>
    <?php
        $address = $digital_sensor->sensor->full_address;
        if($digital_sensor->sensor->device->report->$address == 1) {
            $data = $digital_sensor->sensor->label->on_label;
            $class = 'success';
        } else {
            $data = $digital_sensor->sensor->label->off_label;
            $class = 'secondary';
        }
        $is_output = false;
    ?>
    <?php echo $__env->make('water-management.dashboard.control.html.digital-input',['is_output' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>


<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/digital-output.blade.php ENDPATH**/ ?>