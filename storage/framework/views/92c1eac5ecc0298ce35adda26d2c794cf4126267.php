<?php $__env->startSection('modal-title',''); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo $__env->make('water-management.dashboard.chart.charts.include-charts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Seleccione un rango de fechas</label>
                        <input type="text" class="form-control datepicker" id="date" onchange="filterGraph()">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <hr>
    <div class="row ">
        <div class="col-xl-12 border-bottom">
            <ul class="nav nav-pills justify-content-end" role="tablist">
                <li class="nav-item" id="sensor_list_dropdown"><a class="nav-link border-0" href="javascript:void(0);" data-toggle="dropdown">Agregar Sensores <i class="fal fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <?php $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($sensor->address->configuration_type == 'scale' && $sensor_id != $sensor->id): ?>
                                <li class="list-group-item">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input sensors" value="<?php echo e($sensor->id); ?>" name="sensors[]">
                                        <span class="custom-control-label"><?php echo e($sensor->name); ?></span>
                                    </label>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link border-0"  href="/getDataAsChartExternal/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>" target="_blank"><i class="fal fa-external-link"></i></a></li>

            <?php if($sensor->type->id == 1 && $sensor->selected_disposition()->first()->unit->name == 'mt'): ?>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('average')"><i class="fal fa-clock "></i></a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('daily')"><i class="fal fa-calendar "></i></a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('default')"><i class="fal fa-filter"></i></a></li>

            </ul>
        </div>
    </div>
    <div class="row mt-2">
        <input type="hidden" id="current_graph" value="default">
        <div class="col-xl-12" id="chartDataContainer">

        </div>
        <?php if($sensor->type->id == 1 && $sensor->selected_disposition()->first()->unit->name == 'mt'): ?>
            <span class="p-2 px-6 bg-primary text-white rounded-plus position-relative meter-span " style="top:-40px; left:30px;"><?php echo e($sensor->max_value); ?> <?php echo e($sensor->selected_disposition()->first()->unit->name); ?></span>
        <?php endif; ?>
    </div>


    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>

    <script>

        function downloadData() {
            let date = $('#date').val();

            location.href = '/downloadDataFromChart/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>?dates='+date;
        }

        function changeGraph(graph){
            $('#current_graph').val(graph);
            filterGraph();
        }

        function filterGraph()
        {

            if($('#current_graph').val() === 'default') {
                $('#sensor_list_dropdown').show();
                getDefaultChart();
            } else if($('#current_graph').val() === 'daily') {
                $('#sensor_list_dropdown').hide();
                getDailyAveragesChart();
            } else {
                $('#sensor_list_dropdown').hide();
                getAveragesChart();
            }

        }
        $(document).ready(function(){
            $('.meter-span').hide();
            $('#remoteModal').css({
                width : '100%',
                height : '100%'
            });
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };
            $('.sensors').click(function(){
                getDefaultChart();
            });

            $('.datepicker').daterangepicker(
                {
                    opens: 'right',
                    "parentEl": "#remoteModal",
                    templates: controls,
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    "showDropdowns": true,
                    "showWeekNumbers": true,
                    "showISOWeekNumbers": true,
                    "timePicker": false,
                    "timePicker24Hour": false,
                    "timePickerSeconds": false,
                    "autoApply": false,
                    ranges:
                        {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                            'Esta Semana': [moment().startOf('week'), moment().endOf('week')],
                            'Semana Pasada': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label)
                {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });

            getDefaultChart();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit'); ?>
    <a href="javascript:void(0);" class="btn btn-success float-right" onclick="downloadData()"><i class="fas fa-file-excel"></i> Descargar</a>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/chart/index.blade.php ENDPATH**/ ?>