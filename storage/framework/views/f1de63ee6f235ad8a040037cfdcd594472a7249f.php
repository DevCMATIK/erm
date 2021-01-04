
<?php $__env->startSection('page-title'); ?>
    <?php echo e('Dashboard : '.$subZone->name); ?> <a href="/dashboard-alarms" class="btn-warning btn btn-sm btn-alarm"><i class="fas fa-exclamation-triangle"></i></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','chart-bar'); ?>
<?php $__env->startSection('page-content'); ?>

    <nav class="shortcut-menu  d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <?php if(count($check_point_kpis ) > 0): ?>
            <a href="javascript:void(0);" data-toggle="modal" data-target=".js-modal-kpi" class="menu-item btn"  data-placement="left" title="Ver Kpi">
                <i class="fal fa-chart-pie"></i>
            </a>
        <?php endif; ?>
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
        <?php if(Sentinel::getUser()->hasAccess('dashboard.control-mode')): ?>

            <?php echo $__env->make('water-management.dashboard.partials.output-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php endif; ?>
    </style>

    <div class="row" id="dashboard-content">

    </div>
    <?php if(count($check_point_kpis ) > 0): ?>
    <div class="modal fade js-modal-kpi" tabindex="-1" role="dialog" id="modal-kpi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right modal-md">
            <div class="modal-content h-100">
                <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                    <h4 class="text-white">KPI</h4>
                    <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body  h-100  p-4" id="kpi-container">
                    <?php $__currentLoopData = $check_point_kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row mb-4">
                            <?php echo $__env->make('water-management.dashboard.partials.kpi.cost-kpi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        $('.btn-alarm').hide();
        Highcharts.setOptions({
            global: {
                useUTC: false
            },
            lang: {
                decimalPoint: ',',
                thousandsSep: ''
            }
        });
        getDashboardContent();

        function activeAndNotAccused(device)
        {
            $('.btn-alarm').show();
            $.get('/setAlarmAccused/'+device);
        }
       function getDashboardContent()
       {
           $.get('/getDashboardContent/<?php echo e($subZone->id); ?>',function(data){
               $('#dashboard-content').html(data);
           });
       }
        setInterval(function(){
           getDashboardContent();
        },10000);


    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/sub-zone.blade.php ENDPATH**/ ?>