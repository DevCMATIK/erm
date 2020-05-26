<?php
    if($analogous_sensor->sensor->type->slug == 'ee-energia') {
        $class = 'bg-success-500';
        $icon = 'fa-battery-bolt';
    }elseif($analogous_sensor->sensor->type->slug == 'ee-corriente'){
        $class = 'bg-warning-500';
        $icon = 'fa-bars';
    } elseif($analogous_sensor->sensor->type->slug == 'ee-potencia'){
        $class = 'bg-danger-500';
        $icon = 'fa-tachometer';
    }else {
        $class = 'bg-primary-500';
        $icon = 'fa-bolt';
    }
?>
<div class="p-3 <?php echo e($class); ?> rounded overflow-hidden position-relative text-white mb-g " >

       <div class="">
             <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                <a class="text-white" href="/getDataAsChart/<?php echo e($analogous_sensor->sensor->device_id); ?>/<?php echo e($analogous_sensor->sensor->id); ?>"  <?php echo makeLinkRemote(); ?> id="" ><?php echo e($data); ?><span class="fs-nano"><?php echo e(strtoupper(optional(optional($disposition)->unit)->name)); ?></span></a>
                <small class="m-0 l-h-n"><?php echo e($analogous_sensor->sensor->name); ?></small>
             </h3>
       </div>
        <i class="fas <?php echo e($icon); ?> position-absolute pos-right pos-bottom opacity-15 mb-2 mr-1" style="font-size:5rem"></i>
</div>



<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/control/html/analogous-electric.blade.php ENDPATH**/ ?>