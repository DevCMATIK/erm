<?php $__env->startSection('page-title'); ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-messenger"><i class='subheader-icon fas fa-chart-line'></i>

    <?php echo e($subZone->name .': '.\App\Domain\Client\CheckPoint\CheckPoint::find($check_point )->name); ?></a>
    <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/boost.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <nav class="shortcut-menu  d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-messenger" class="menu-item btn"  data-placement="left" title="Ver puntos de Control">
            <i class="fal fa-bars"></i>
        </a>
        <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-kpi" class="menu-item btn"  data-placement="left" title="Ver Kpi">
            <i class="fal fa-chart-pie"></i>
        </a>
        <a href="/dashboard/<?php echo e($subZone->id); ?>"  class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Volver al Dashboard">
            <i class="fal fa-chart-line"></i>
        </a>
        <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
            <i class="fal fa-arrow-up"></i>
        </a>
    </nav>
    <style>
        .progress-bar-vertical {
            width: 80%;
            margin: auto;
            min-height: 140px;
            display: flex;
            align-items: flex-end;
            border-radius: 5px !important;
        }

        .progress-bar-vertical .progress-bar {
            width: 100%;
            height: 0;
            -webkit-transition: height 0.6s ease;
            -o-transition: height 0.6s ease;
            transition: height 0.6s ease;
        }
        <?php echo $__env->make('water-management.dashboard.partials.output-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </style>
    <?php
        $options = false;
    ?>
    <?php echo $__env->make('water-management.dashboard.partials.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div  id="device-content" class="bg-">

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>

    <script>
        $('.btn-alarm').hide();
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        getDeviceContent();
        $(document).ready(function(){
            getAllKpi();

            function getAllKpi()
            {

            }



            function getTotalizerKpi()
            {
                $.get('/getTotalizerKpi/<?php echo e($check_point); ?>',function(data){
                    $('#kpi-totalizer-content').html(data);
                });
            }
        });




        function activeAndNotAccused(device)
        {
            $('.btn-alarm').show();
            $.get('/setAlarmAccused/'+device);
        }

        function getDeviceContent()
        {
            $.get('/getDeviceContent/<?php echo e($check_point); ?>',function(data){
                $('#device-content').html(data);
            });
        }





        setInterval(function(){
            getDeviceContent();
        },10000);


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/device.blade.php ENDPATH**/ ?>