<?php $__env->startSection('modal-title',''); ?>
<?php $__env->startSection('modal-content'); ?>
    <style>
        .swal2-container {
            z-index: 300000;
        }
    </style>
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
                    <ul class="dropdown-menu" style="max-height: 300px; overflow-y: auto;">
                        <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $dev->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($s->address->configuration_type == 'scale' && $sensor_id != $s->id): ?>
                                    <li class="list-group-item">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input sensors" value="<?php echo e($s->id); ?>" name="sensors[]">
                                            <span class="custom-control-label"><?php echo e($s->name); ?></span>
                                        </label>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link border-0"  href="/getDataAsChartExternal/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>" target="_blank"><i class="fal fa-external-link"></i></a></li>

                <?php if($sensor->type->id == 1 && (optional(optional($sensor->selected_disposition()->first())->unit)->name == 'mt' || optional(optional($sensor->dispositions()->first())->unit)->name == 'mt')): ?>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('average')"><i class="fal fa-clock "></i></a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('daily')"><i class="fal fa-calendar "></i></a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab"  href="javascript:void(0);" onclick="changeGraph('default')"><i class="fal fa-filter"></i></a></li>
                <input type="hidden" id="diffInDays" value="0">
            </ul>
        </div>
    </div>
    <div class="row mt-2">
        <input type="hidden" id="current_graph" value="default">
        <div class="col-xl-12" id="chartDataContainer">

        </div>

    </div>
    <?php if(count($sensor->type->interpreters) > 0): ?>
        <hr>
        <div class="row mt-2">
            <div class="col-12">
                <h5>Manual de interpretación para <?php echo e($sensor->type->name); ?></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Valor Leído</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $sensor->type->interpreters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interpreter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($interpreter->value); ?></td>
                            <td><?php echo e($interpreter->name); ?></td>
                            <td><?php echo e($interpreter->description); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <input type="hidden" value="<?php echo e($sensor->id); ?>" name="sensor_selected" id="sensor_selected">
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>

    <script>

        function downloadData() {
            let date = $('#date').val();
            var sensors  = $('.sensors').serialize();
            let diffInDays = $('#diffInDays').val();
            if(diffInDays > 30) {
                $.ajax({
                    url     : '/downloadDataFromChart/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>?dates='+date+'&'+sensors,
                    type    : 'GET',
                    dataType: "json",
                    success : function ( json )
                    {
                        if(json.success === 'Export Started') {
                            Swal.fire(
                                {
                                    title: "<strong><u>Importante!</u></strong>",
                                    type: "info",
                                    html: "Debido a la cantidad de data, se ha generado una descarga en segundo plano, un correo será enviado cuando sus archivos estén listos.",
                                    showCloseButton: true,
                                    showCancelButton: false,
                                });
                        }


                    },

                });
            } else {
                location.href = '/downloadDataFromChart/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>?dates='+date+'&'+sensors+'&noAjax=true';
            }


        }

        function downloadConsumptionData() {
            toastr.info('Se está generando el archivo')
            location.href = '/downloadWaterConsumptionData/<?php echo e($sensor_id); ?>?&noAjax=true';


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
                    $('#diffInDays').val(Math.ceil((end - start) / (1000 * 60 * 60 * 24)));

                });

        });
    </script>
    <?php if(Session::has('success')): ?>
        <script>

        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit'); ?>
    <a href="javascript:void(0);" class="btn btn-success float-right" onclick="downloadData()"><i class="fas fa-file-excel"></i> Históricos</a>
    <?php if($sensor->type->sensor_type == 'tote'): ?>
        <a href="javascript:void(0);" class="btn btn-success float-right mr-2" onclick="downloadConsumptionData()"><i class="fas fa-file-excel"></i> Consumo</a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/chart/index.blade.php ENDPATH**/ ?>