
<?php $__env->startSection('page-content'); ?>

    <div class="row ">

        <div class="col-xl-12">
            <?php echo $__env->make('water-management.dashboard.statistics.small-boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="row">
                <div class="col-xl-12" id="cupLevelsContainer">

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
        'plugins/highcharts/highcharts.js',
        'plugins/highcharts/modules/boost.js',
        'plugins/highcharts/modules/exporting.js',
    ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        function redirectToAlarms()
        {
            location.href = "/dashboard-alarms";
        }

        function redirectToOfflineDevices()
        {
            location.href = "/offline-devices";
        }

        function redirectToOfflineDev()
        {
            location.href = "/offline-devices-list";
        }


        $(document).ready(function(){
            getOnlineDevices();
            getAlarmsOn();
            getLastUpdate();


            $.get('/kpi/getCupLevels', function (data) {
                $('#cupLevelsContainer').html(data);
            });
        });

        function getOnlineDevices()
        {
            $.get('/kpi/getOnlineDevices',function(data){
                $('#online-devices').html(data);
            });
        }

        function getAlarmsOn()
        {
            $.get('/kpi/getAlarmsOn',function(data){
                $('#alarms-on').html(data);
            });
        }

        function getLastUpdate()
        {
            $.get('/kpi/getLastUpdate',function(data){
                $('#last-update').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/main.blade.php ENDPATH**/ ?>