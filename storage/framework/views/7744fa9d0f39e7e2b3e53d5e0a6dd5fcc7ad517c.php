<?php if(isset($options) && $options['digital'] == 'outputs-as-states'): ?>
    <?php
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
    ?>
<?php else: ?>
    <?php if($digital_sensor->sensor->address->slug == 'i' || $digital_sensor->is_not_an_output == 1): ?>
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
    <?php endif; ?>
<?php endif; ?>
<?php if(Sentinel::getUser()->hasAccess('dashboard.control-mode') && $is_output === true): ?>
    <?php echo $__env->make('water-management.dashboard.control.digital-output', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('water-management.dashboard.control.html.digital-input',['is_output' => $is_output], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/digital-input.blade.php ENDPATH**/ ?>