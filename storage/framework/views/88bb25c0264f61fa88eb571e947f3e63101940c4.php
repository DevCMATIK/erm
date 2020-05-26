<?php $__env->startSection('page-title'); ?>
    <?php echo e('Dashboard : '.$subZone->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','bolt'); ?>
<?php $__env->startSection('page-content'); ?>


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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>

        getDashboardContent();

        function activeAndNotAccused(device)
        {
            $.get('/setAlarmAccused/'+device);
        }
        function getDashboardContent()
        {
            $.get('/getDashboardContentElectric/<?php echo e($subZone->id); ?>',function(data){
                $('#dashboard-content').html(data);
            });
        }
        setInterval(function(){
            getDashboardContent();
        },10000);


    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/views/sub-zone-electric.blade.php ENDPATH**/ ?>