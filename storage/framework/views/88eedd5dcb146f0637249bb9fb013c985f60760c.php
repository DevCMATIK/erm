<?php echo includeScript(
    'js/app.js',
    'js/app.vendor.js',
    'js/app.blunde.js',
    'plugins/toastr/toastr.js',
    'plugins/sweetalert2/sweetalert2.js',
    'js/forms.js',
    'js/confirmAction.js',
    'js/moment.js',
    'plugins/easypiechart/easypiechart.bundle.js'
); ?>

<?php if (! empty(trim($__env->yieldContent('more-scripts')))): ?>
    <?php echo $__env->yieldContent('more-scripts'); ?>
<?php endif; ?>
<?php if(Sentinel::check()): ?>
    <?php
        $mainZones = \App\Domain\Client\Zone\Zone::with('sub_zones.configuration')->get()->filter(function($item){
               return $item->sub_zones->filter(function($sub_zone) {
                       return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);
                   })->count() > 0;
           });
    ?>
    <?php if(isset($mainZones) && count($mainZones) > 0): ?>
        <script>

            function getSubZoneStatus(sub_zone) {
                $.getJSON('/getSubZoneDeviceState/'+sub_zone, function(data) {
                    if(data.offline > 0) {
                        $('#sub_zone_a_'+sub_zone).append('<span class="label mt-1 float-right px-2 fs-nano text-warning"><i class="fal fa-power-off"></i></span>');
                    }
                });
            }



            function getSubZoneAlarms(sub_zone) {
                $.getJSON('/getSubZoneDeviceAlarm/'+sub_zone, function(data) {
                    if(data.accused > 0) {
                        $('#sub_zone_a_'+sub_zone).append('<span title="Posee Alarmas Activas Acusadas" class="label float-right p-1  text-warning"><i class="fas fa-exclamation-triangle"></i></span>');
                    }
                    if(data.active > 0) {
                        $('#sub_zone_a_'+sub_zone).append('<span title="Posee Alarmas Activas" class="label p-1    text-danger"><i class="fas fa-exclamation-triangle"></i></span>');
                    }

                });
            }

            function getZoneAlarms(zone) {
                $.getJSON('/getZoneDeviceAlarm/'+zone, function(data) {
                    if(data.accused > 0) {
                        $('#zone_a_'+zone).removeClass('fal').addClass('fas text-warning');
                    }
                    if(data.active > 0) {
                        $('#zone_a_'+zone).removeClass('fal').addClass('fas text-danger');
                    }

                });
            }

            $(document).ready(function(){


                <?php $__currentLoopData = $mainZones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                getSubZoneAlarms(<?php echo e($sub_zone->id); ?>);
                getSubZoneStatus(<?php echo e($sub_zone->id); ?>);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                getZoneAlarms(<?php echo e($zone->id); ?>);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            });
        </script>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /Users/sebaaraya/devilbox/data/www/erm/resources/views/components/html-helpers/core-scripts.blade.php ENDPATH**/ ?>