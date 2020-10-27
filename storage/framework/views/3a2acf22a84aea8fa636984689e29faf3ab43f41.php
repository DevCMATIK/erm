
<?php $__env->startSection('page-title','Control de Alarmas'); ?>
<?php $__env->startSection('page-icon','exclamation-triangle'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row ">
        <div class="col-xl-12">
            <?php echo $__env->make('water-management.dashboard.alarm.boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-xl-12">
                    <div id="panel-alarms-table" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                Alarmas Activas
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            </div>
                        </div>
                        <div class="panel-container show ">
                            <div class="panel-content table-responsive p-0" id="active-alarms-table">

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div id="panel-last-alarms-table" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                Ultimas 50 Alarmas
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            </div>
                        </div>
                        <div class="panel-container show ">
                            <div class="panel-content table-responsive p-0" id="last-alarms-table">

                            </div>
                        </div>
                    </div>

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


        $(document).ready(function(){
            getAlarmsTotal();
            getAlarmsOn();
            getLastAlarm();
            getActiveAlarmsTable();
            getLastAlarmsTable();



        });

        function getAlarmsTotal()
        {
            $.get('/kpi/getAlarmsTotal',function(data){
                $('#alarms-total').html(data);
            });
        }

        function getAlarmsOn()
        {
            $.get('/kpi/getAlarmsOn',function(data){
                $('#alarms-on').html(data);
            });
        }

        function getLastAlarm()
        {
            $.get('/kpi/getLastAlarm',function(data){
                $('#last-alarm').html(data);
            });
        }

        function getActiveAlarmsTable()
        {
            $.get('/dashboard-alarms/getActiveAlarmsTable',function(data){
                $('#active-alarms-table').html(data);
            });
        }

        function getLastAlarmsTable()
        {
            $.get('/dashboard-alarms/getLastAlarmsTable',function(data){
                $('#last-alarms-table').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/alarm/index.blade.php ENDPATH**/ ?>