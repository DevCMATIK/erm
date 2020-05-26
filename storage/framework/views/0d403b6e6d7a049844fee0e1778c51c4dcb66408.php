
<?php $__env->startSection('page-title'); ?>
    <?php echo e('Dashboard : '.$subZone->name); ?>


    <?php echo makeLink('/dashboard/'.$subZone->id,'Dashboard','fa-chart-bar','btn-primary float-right'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','chart-bar'); ?>
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

        <?php echo $__env->make('water-management.dashboard.partials.output-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </style>

    <div class="row" id="control-content">


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        getControlContent();


        function activeAndNotAccused(device)
        {
            $.get('/setAlarmAccused/'+device);
        }

        function getControlContent()
        {
            $.get('/getControlContent/<?php echo e($subZone->id); ?>',function(data){
                $('#control-content').html(data);
            });
        }
        setInterval(function(){
            getControlContent();
        },10000);

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/views/control.blade.php ENDPATH**/ ?>